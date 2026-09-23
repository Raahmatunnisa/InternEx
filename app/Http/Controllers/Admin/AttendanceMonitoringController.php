<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ImportAttendanceRequest;
use App\Models\Attendance;
use App\Models\Internship;
use App\Models\InternshipPeriod;
use App\Services\Xlsx\XlsxReader;
use App\Services\Xlsx\XlsxWriter;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class AttendanceMonitoringController extends Controller
{
    /**
     * Monitoring kehadiran seluruh mahasiswa magang. Menggunakan sumber
     * data attendances yang sama dengan fitur Kehadiran pada role Mentor
     * (tabel `attendances`), tidak ada tabel/data terpisah.
     */
    public function index(Request $request): View
    {
        $baseQuery = Internship::query()
            ->with(['student', 'period'])
            ->when($request->filled('internship_period_id'), fn ($q) => $q
                ->where('internship_period_id', $request->integer('internship_period_id')))
            ->when($request->filled('internship_id'), fn ($q) => $q
                ->where('id', $request->integer('internship_id')));

        $allMatchingIds = (clone $baseQuery)->pluck('id');

        $internships = (clone $baseQuery)->orderBy('id')->paginate(15)->withQueryString();

        $counts = Attendance::whereIn('internship_id', $allMatchingIds)
            ->when($request->filled('date_from'), fn ($q) => $q->whereDate('date', '>=', $request->date('date_from')))
            ->when($request->filled('date_to'), fn ($q) => $q->whereDate('date', '<=', $request->date('date_to')))
            ->selectRaw('internship_id, status, COUNT(*) as total')
            ->groupBy('internship_id', 'status')
            ->get()
            ->groupBy('internship_id');

        $recap = [];
        foreach ($internships as $internship) {
            $recap[$internship->id] = $this->buildRecap($counts->get($internship->id, collect()));
        }

        $summary = $this->buildRecap(
            Attendance::whereIn('internship_id', $allMatchingIds)
                ->when($request->filled('date_from'), fn ($q) => $q->whereDate('date', '>=', $request->date('date_from')))
                ->when($request->filled('date_to'), fn ($q) => $q->whereDate('date', '<=', $request->date('date_to')))
                ->selectRaw('status, COUNT(*) as total')
                ->groupBy('status')
                ->get()
                ->map(fn ($row) => (object) ['status' => $row->status, 'total' => $row->total])
        );

        $periods = InternshipPeriod::orderByDesc('start_date')->get();
        $students = Internship::with('student')->orderBy('id')->get();

        return view('admin.attendance-monitoring.index', [
            'internships' => $internships,
            'recap' => $recap,
            'summary' => $summary,
            'periods' => $periods,
            'students' => $students,
        ]);
    }

    /**
     * Detail kehadiran harian satu mahasiswa.
     */
    public function detail(Internship $internship, Request $request): View
    {
        $internship->load(['student', 'mentor', 'period']);

        $attendances = $internship->attendances()
            ->when($request->filled('date_from'), fn ($q) => $q->whereDate('date', '>=', $request->date('date_from')))
            ->when($request->filled('date_to'), fn ($q) => $q->whereDate('date', '<=', $request->date('date_to')))
            ->latest('date')
            ->paginate(20)
            ->withQueryString();

        $summary = $this->buildRecap(
            (clone $internship->attendances())
                ->when($request->filled('date_from'), fn ($q) => $q->whereDate('date', '>=', $request->date('date_from')))
                ->when($request->filled('date_to'), fn ($q) => $q->whereDate('date', '<=', $request->date('date_to')))
                ->selectRaw('status, COUNT(*) as total')
                ->groupBy('status')
                ->get()
        );

        return view('admin.attendance-monitoring.detail', [
            'internship' => $internship,
            'attendances' => $attendances,
            'summary' => $summary,
        ]);
    }

    public function importForm(): View
    {
        $periods = InternshipPeriod::orderByDesc('start_date')->get();

        return view('admin.attendance-monitoring.import', ['periods' => $periods]);
    }

    /**
     * Import data kehadiran dari file Excel (format export absensi seperti
     * kolom: No, Date Created, Waktu Presensi, Nama Lengkap, Jabatan,
     * Tanggal, Tanda Tangan). Kolom Jabatan & Tanda Tangan tidak diambil.
     * Hasil import langsung disimpan ke tabel attendances yang sama dipakai
     * fitur Kehadiran Mentor & Mahasiswa.
     */
    public function import(ImportAttendanceRequest $request): RedirectResponse
    {
        $periodId = (int) $request->validated()['internship_period_id'];
        $file = $request->file('file');

        try {
            $rows = XlsxReader::read($file->getRealPath());
        } catch (\Throwable $e) {
            return back()->withInput()->with('error', 'Gagal membaca file: '.$e->getMessage());
        }

        if (count($rows) < 2) {
            return back()->withInput()->with('error', 'File tidak berisi data (hanya header atau kosong).');
        }

        $header = array_shift($rows);
        $columnMap = $this->mapHeader($header);

        if (! isset($columnMap['nama lengkap']) || ! isset($columnMap['waktu presensi'])) {
            return back()->withInput()->with('error',
                'Format file tidak sesuai. Pastikan file memiliki kolom "Nama Lengkap" dan "Waktu Presensi" (contoh format export absensi tanda tangan digital).');
        }

        if (! isset($columnMap['date created']) && ! isset($columnMap['tanggal'])) {
            return back()->withInput()->with('error',
                'Format file tidak sesuai. Pastikan file memiliki kolom "Date Created" atau "Tanggal".');
        }

        $internshipsByName = Internship::where('internship_period_id', $periodId)
            ->with('student')
            ->get()
            ->filter(fn ($i) => $i->student)
            ->keyBy(fn ($i) => mb_strtolower(trim($i->student->name)));

        $grouped = [];
        $unmatchedNames = [];
        $rowErrors = [];
        $processed = 0;

        foreach ($rows as $index => $row) {
            $lineNumber = $index + 2; // +1 header, +1 karena index mulai dari 0

            $name = trim($row[$columnMap['nama lengkap']] ?? '');
            if ($name === '') {
                continue; // baris kosong, lewati
            }

            $processed++;

            $dateRaw = trim($row[$columnMap['date created'] ?? -1] ?? '')
                ?: trim($row[$columnMap['tanggal'] ?? -1] ?? '');

            if ($dateRaw === '') {
                $rowErrors[] = "Baris {$lineNumber}: tanggal kosong, dilewati.";

                continue;
            }

            $dateTime = $this->parseDateValue($dateRaw);

            if (! $dateTime) {
                $rowErrors[] = "Baris {$lineNumber}: format tanggal \"{$dateRaw}\" tidak dikenali, dilewati.";

                continue;
            }

            $key = mb_strtolower($name);

            if (! isset($internshipsByName[$key])) {
                $unmatchedNames[$name] = true;

                continue;
            }

            $internship = $internshipsByName[$key];
            $waktu = mb_strtolower(trim($row[$columnMap['waktu presensi']] ?? ''));
            $dateKey = $dateTime->toDateString();
            $timeValue = $dateTime->format('H:i:s');

            $grouped[$internship->id] ??= [];
            $grouped[$internship->id][$dateKey] ??= [];

            if (str_contains($waktu, 'datang') || str_contains($waktu, 'masuk')) {
                $grouped[$internship->id][$dateKey]['check_in_time'] = $timeValue;
            } elseif (str_contains($waktu, 'pulang') || str_contains($waktu, 'keluar')) {
                $grouped[$internship->id][$dateKey]['check_out_time'] = $timeValue;
            } elseif (! isset($grouped[$internship->id][$dateKey]['check_in_time'])) {
                $grouped[$internship->id][$dateKey]['check_in_time'] = $timeValue;
            } else {
                $grouped[$internship->id][$dateKey]['check_out_time'] = $timeValue;
            }
        }

        $savedRecords = 0;

        DB::transaction(function () use ($grouped, &$savedRecords) {
            foreach ($grouped as $internshipId => $dates) {
                foreach ($dates as $dateKey => $times) {
                    $attrs = $times;
                    $attrs['status'] = 'hadir';

                    Attendance::updateOrCreate(
                        ['internship_id' => $internshipId, 'date' => $dateKey],
                        $attrs
                    );

                    $savedRecords++;
                }
            }
        });

        $message = "Import selesai. {$savedRecords} data kehadiran tersimpan dari {$processed} baris data.";

        if (! empty($unmatchedNames)) {
            $names = implode(', ', array_slice(array_keys($unmatchedNames), 0, 10));
            $message .= ' Nama tidak ditemukan pada periode ini ('.count($unmatchedNames)." nama): {$names}".(count($unmatchedNames) > 10 ? ', ...' : '');
        }

        return redirect()->route('admin.attendance-monitoring.index')
            ->with(empty($unmatchedNames) && empty($rowErrors) ? 'success' : 'warning', $message);
    }

    /**
     * Cetak/unduh dokumen Excel data kehadiran sesuai filter yang aktif.
     */
    public function export(Request $request): BinaryFileResponse
    {
        $attendances = Attendance::query()
            ->with(['internship.student', 'internship.period'])
            ->whereHas('internship', function ($q) use ($request) {
                $q->when($request->filled('internship_period_id'), fn ($q2) => $q2
                    ->where('internship_period_id', $request->integer('internship_period_id')));
                $q->when($request->filled('internship_id'), fn ($q2) => $q2
                    ->where('id', $request->integer('internship_id')));
            })
            ->when($request->filled('date_from'), fn ($q) => $q->whereDate('date', '>=', $request->date('date_from')))
            ->when($request->filled('date_to'), fn ($q) => $q->whereDate('date', '<=', $request->date('date_to')))
            ->orderBy('date')
            ->get();

        $writer = new XlsxWriter();
        $writer->setSheetName('Kehadiran');
        $writer->setHeader(['No', 'Nama Mahasiswa', 'Periode Magang', 'Tanggal', 'Jam Masuk', 'Jam Pulang', 'Status']);

        foreach ($attendances as $index => $attendance) {
            $writer->addRow([
                $index + 1,
                $attendance->internship->student->name ?? '-',
                $attendance->internship->period->name ?? '-',
                $attendance->date->format('Y-m-d'),
                $attendance->check_in_time?->format('H:i') ?? '-',
                $attendance->check_out_time?->format('H:i') ?? '-',
                ucfirst($attendance->status),
            ]);
        }

        $fileName = 'kehadiran-'.now()->format('Ymd-His').'.xlsx';
        $tempPath = tempnam(sys_get_temp_dir(), 'xlsx_export_');
        $writer->save($tempPath);

        return response()->download($tempPath, $fileName, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ])->deleteFileAfterSend(true);
    }

    /**
     * @param  \Illuminate\Support\Collection  $statusCounts
     * @return array{hadir:int, izin:int, sakit:int, alpha:int, total:int, percentage:float}
     */
    protected function buildRecap($statusCounts): array
    {
        $counts = ['hadir' => 0, 'terlambat' => 0, 'izin' => 0, 'sakit' => 0, 'alpha' => 0];

        foreach ($statusCounts as $row) {
            $counts[$row->status] = (int) $row->total;
        }

        $hadir = $counts['hadir'] + $counts['terlambat'];
        $total = $hadir + $counts['izin'] + $counts['sakit'] + $counts['alpha'];
        $percentage = $total > 0 ? round(($hadir / $total) * 100, 1) : 0.0;

        return [
            'hadir' => $hadir,
            'izin' => $counts['izin'],
            'sakit' => $counts['sakit'],
            'alpha' => $counts['alpha'],
            'total' => $total,
            'percentage' => $percentage,
        ];
    }

    /**
     * @param  array<int, string>  $header
     * @return array<string, int>
     */
    protected function mapHeader(array $header): array
    {
        $map = [];

        foreach ($header as $index => $value) {
            $key = mb_strtolower(trim((string) $value));

            if ($key !== '') {
                $map[$key] = $index;
            }
        }

        return $map;
    }

    protected function parseDateValue(string $value): ?Carbon
    {
        if (is_numeric($value)) {
            // Serial tanggal Excel (epoch 1899-12-30, termasuk bug tahun kabisat 1900).
            $serial = (float) $value;

            try {
                return Carbon::create(1899, 12, 30, 0, 0, 0)
                    ->addDays((int) floor($serial))
                    ->addSeconds((int) round(($serial - floor($serial)) * 86400));
            } catch (\Throwable $e) {
                return null;
            }
        }

        try {
            return Carbon::parse($value);
        } catch (\Throwable $e) {
            return null;
        }
    }
}
