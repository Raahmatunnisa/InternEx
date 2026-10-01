<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Internship;
use App\Models\InternshipPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class PerformanceMonitoringController extends Controller
{
    /**
     * Monitoring progress seluruh mahasiswa magang: pengisian logbook
     * harian & laporan akhir. Bisa difilter per nama mahasiswa & periode
     * magang.
     */
    public function index(Request $request): View
    {
        $internships = Internship::query()
            ->with(['student', 'period', 'finalReport'])
            ->when($request->filled('internship_period_id'), fn ($q) => $q
                ->where('internship_period_id', $request->integer('internship_period_id')))
            ->when($request->filled('search'), fn ($q) => $q
                ->whereHas('student', fn ($q2) => $q2
                    ->where('name', 'like', '%'.$request->string('search').'%')))
            ->orderBy('id')
            ->paginate(10)
            ->withQueryString();

        $periods = InternshipPeriod::orderByDesc('start_date')->get();

        return view('admin.performance-monitoring.index', [
            'internships' => $internships,
            'periods' => $periods,
        ]);
    }

    /**
     * Detail kinerja satu mahasiswa: progress logbook & laporan, daftar
     * logbook (yang sudah disetujui mentor), serta akses ke file laporan
     * akhir yang sudah disetujui mentor.
     */
    public function detail(Internship $internship, Request $request): View
    {
        $internship->load(['student', 'mentor', 'period', 'finalReport']);

        $logbooks = $internship->logbooks()
            ->where('status', 'approved')
            ->orderByDesc('date')
            ->paginate(10)
            ->withQueryString();

        $logbookTotals = [
            'approved' => $internship->logbooks()->where('status', 'approved')->count(),
            'submitted' => $internship->logbooks()->where('status', 'submitted')->count(),
            'rejected' => $internship->logbooks()->where('status', 'rejected')->count(),
        ];

        return view('admin.performance-monitoring.detail', [
            'internship' => $internship,
            'logbooks' => $logbooks,
            'logbookTotals' => $logbookTotals,
        ]);
    }

    /**
     * Preview file laporan akhir (hanya jika sudah disetujui mentor).
     */
    public function reportPreview(Internship $internship)
    {
        $finalReport = $internship->finalReport;

        abort_if(! $finalReport || $finalReport->status !== 'approved', 404,
            'Laporan akhir belum tersedia atau belum disetujui mentor.');
        abort_unless($finalReport->file_path && Storage::disk('local')->exists($finalReport->file_path), 404);

        return Storage::disk('local')->response($finalReport->file_path);
    }

    /**
     * Unduh file laporan akhir (hanya jika sudah disetujui mentor).
     */
    public function reportDownload(Internship $internship)
    {
        $finalReport = $internship->finalReport;

        abort_if(! $finalReport || $finalReport->status !== 'approved', 404,
            'Laporan akhir belum tersedia atau belum disetujui mentor.');
        abort_unless($finalReport->file_path && Storage::disk('local')->exists($finalReport->file_path), 404);

        $studentName = str_replace(' ', '_', $internship->student->name ?? 'mahasiswa');
        $extension = pathinfo($finalReport->file_path, PATHINFO_EXTENSION) ?: 'pdf';

        return Storage::disk('local')->download(
            $finalReport->file_path,
            "laporan-akhir-{$studentName}.{$extension}"
        );
    }

    /**
     * Dokumen cetak logbook (hanya entri yang sudah disetujui mentor).
     * Dipakai untuk preview (buka tab baru) & unduh (memicu print dialog
     * browser secara otomatis, sama seperti dokumen penilaian).
     */
    public function logbookDocument(Internship $internship, Request $request): View
    {
        $internship->load(['student', 'mentor', 'period']);

        $logbooks = $internship->logbooks()
            ->where('status', 'approved')
            ->orderBy('date')
            ->get();

        return view('admin.performance-monitoring.logbook-document', [
            'internship' => $internship,
            'logbooks' => $logbooks,
            'autoPrint' => $request->boolean('unduh'),
        ]);
    }
}
