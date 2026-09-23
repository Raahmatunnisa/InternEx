<?php

namespace App\Http\Controllers\Mentor;

use App\Http\Controllers\Controller;
use App\Http\Requests\Mentor\StoreAttendanceRequest;
use App\Http\Requests\Mentor\UpdateAttendanceRequest;
use App\Models\Attendance;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AttendanceMonitoringController extends Controller
{
    public function index(Request $request): View
    {
        $studentIds = $request->user()->studentInternships()->pluck('id');

        $attendances = Attendance::whereIn('internship_id', $studentIds)
            ->with('internship.student')
            ->when($request->filled('student_id'), fn ($q) => $q->where('internship_id', $request->integer('student_id')))
            ->when($request->filled('status'), fn ($q) => $q->where('status', $request->string('status')))
            ->when($request->filled('date_from'), fn ($q) => $q->whereDate('date', '>=', $request->date('date_from')))
            ->when($request->filled('date_to'), fn ($q) => $q->whereDate('date', '<=', $request->date('date_to')))
            ->latest('date')
            ->paginate(15)
            ->withQueryString();

        $students = $request->user()->studentInternships()->with('student')->get();

        $summary = [
            'hadir' => Attendance::whereIn('internship_id', $studentIds)->where('status', 'hadir')->count(),
            'terlambat' => Attendance::whereIn('internship_id', $studentIds)->where('status', 'terlambat')->count(),
            'izin' => Attendance::whereIn('internship_id', $studentIds)->where('status', 'izin')->count(),
            'sakit' => Attendance::whereIn('internship_id', $studentIds)->where('status', 'sakit')->count(),
            'alpha' => Attendance::whereIn('internship_id', $studentIds)->where('status', 'alpha')->count(),
        ];

        return view('mentor.attendance-monitoring.index', [
            'attendances' => $attendances,
            'students' => $students,
            'summary' => $summary,
        ]);
    }

    /**
     * Form untuk mentor menambahkan riwayat absen secara manual, dipakai
     * untuk mengisi kehadiran yang bolong/belum tercatat.
     */
    public function create(Request $request): View
    {
        $students = $request->user()->studentInternships()->with('student')->get();

        return view('mentor.attendance-monitoring.create', ['students' => $students]);
    }

    /**
     * Simpan riwayat absen baru. Karena satu mahasiswa hanya punya satu
     * baris kehadiran per tanggal, jika tanggal yang dipilih sudah ada
     * datanya maka data tersebut akan diperbarui (bukan dobel).
     */
    public function store(StoreAttendanceRequest $request): RedirectResponse
    {
        $data = $request->validated();

        $attendance = Attendance::updateOrCreate(
            ['internship_id' => $data['internship_id'], 'date' => $data['date']],
            [
                'status' => $data['status'],
                'check_in_time' => $data['check_in_time'] ?: null,
                'check_out_time' => $data['check_out_time'] ?: null,
            ]
        );

        return redirect()->route('attendance-monitoring.index')
            ->with('success', 'Riwayat absen '.$attendance->internship->student->name.' berhasil ditambahkan.');
    }

    /**
     * Form untuk mentor mengubah status kehadiran (mis. jadi izin/sakit)
     * atau membetulkan jam masuk/pulang mahasiswa binaannya.
     */
    public function edit(Attendance $attendance): View
    {
        $this->authorize('update', $attendance);

        $attendance->load('internship.student');

        return view('mentor.attendance-monitoring.edit', ['attendance' => $attendance]);
    }

    public function update(UpdateAttendanceRequest $request, Attendance $attendance): RedirectResponse
    {
        $data = $request->validated();

        $attendance->update([
            'status' => $data['status'],
            'check_in_time' => $data['check_in_time'] ?: null,
            'check_out_time' => $data['check_out_time'] ?: null,
        ]);

        return redirect()->route('attendance-monitoring.index')
            ->with('success', 'Status kehadiran '.$attendance->internship->student->name.' berhasil diperbarui.');
    }

    /**
     * Hapus data kehadiran yang keliru, misalnya mahasiswa sempat absen
     * padahal hari tersebut merupakan hari libur.
     */
    public function destroy(Attendance $attendance): RedirectResponse
    {
        $this->authorize('delete', $attendance);

        $attendance->delete();

        return redirect()->route('attendance-monitoring.index')
            ->with('success', 'Data kehadiran berhasil dihapus.');
    }
}
