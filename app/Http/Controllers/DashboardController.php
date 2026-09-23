<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(Request $request): View|RedirectResponse
    {
        $user = $request->user();

        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }

        if ($user->isMentor()) {
            return $this->mentorDashboard($user);
        }

        return $this->studentDashboard($user);
    }

    protected function studentDashboard($user): View
    {
        $internship = $user->internship()->with(['mentor', 'period', 'division'])->first();

        if (! $internship) {
            return view('dashboard.mahasiswa', [
                'internship' => null,
            ]);
        }

        $logbooks = $internship->logbooks();
        $attendances = $internship->attendances();

        $attendanceSummary = [
            'hadir' => (clone $attendances)->where('status', 'hadir')->count(),
            'terlambat' => (clone $attendances)->where('status', 'terlambat')->count(),
            'izin' => (clone $attendances)->where('status', 'izin')->count(),
            'sakit' => (clone $attendances)->where('status', 'sakit')->count(),
            'alpha' => (clone $attendances)->where('status', 'alpha')->count(),
        ];
        $totalAttendanceRecords = array_sum($attendanceSummary);
        $attendancePercentage = $totalAttendanceRecords > 0
            ? (int) round((($attendanceSummary['hadir'] + $attendanceSummary['terlambat']) / $totalAttendanceRecords) * 100)
            : 0;

        $stats = [
            'total_logbook' => (clone $logbooks)->count(),
            'logbook_pending' => (clone $logbooks)->where('status', 'submitted')->count(),
            'logbook_approved' => (clone $logbooks)->where('status', 'approved')->count(),
            'total_attendance' => $attendanceSummary['hadir'] + $attendanceSummary['terlambat'],
        ];

        $finalReport = $internship->finalReport;
        $recentLogbooks = (clone $logbooks)->latest('date')->limit(5)->get();
        $todayAttendance = (clone $attendances)->whereDate('date', today())->first();
        $pendingPermits = $internship->permits()->where('status', 'pending')->count();

        return view('dashboard.mahasiswa', [
            'internship' => $internship,
            'stats' => $stats,
            'finalReport' => $finalReport,
            'recentLogbooks' => $recentLogbooks,
            'todayAttendance' => $todayAttendance,
            'attendanceSummary' => $attendanceSummary,
            'attendancePercentage' => $attendancePercentage,
            'pendingPermits' => $pendingPermits,
        ]);
    }

    protected function mentorDashboard($user): View
    {
        $internships = $user->studentInternships();
        $internshipIds = (clone $internships)->pluck('id');

        $stats = [
            'total_students' => (clone $internships)->count(),
            'active_students' => (clone $internships)->where('status', 'active')->count(),
            'pending_logbooks' => \App\Models\Logbook::whereIn('internship_id', $internshipIds)
                ->where('status', 'submitted')->count(),
            'pending_reports' => \App\Models\FinalReport::whereIn('internship_id', $internshipIds)
                ->where('status', 'submitted')->count(),
            'pending_permits' => \App\Models\Permit::whereIn('internship_id', $internshipIds)
                ->where('status', 'pending')->count(),
        ];

        $recentAttendances = \App\Models\Attendance::whereIn('internship_id', $internshipIds)
            ->with('internship.student')
            ->latest('date')
            ->limit(5)
            ->get();

        $activePeriods = \App\Models\InternshipPeriod::where('status', 'active')->latest()->limit(5)->get();

        // Mahasiswa (dengan status magang aktif) yang belum memiliki record kehadiran hari ini.
        $activeInternshipIds = (clone $internships)->where('status', 'active')->pluck('id');
        $checkedInTodayIds = \App\Models\Attendance::whereIn('internship_id', $activeInternshipIds)
            ->whereDate('date', today())
            ->pluck('internship_id');
        $notYetAttendedToday = \App\Models\Internship::whereIn('id', $activeInternshipIds)
            ->whereNotIn('id', $checkedInTodayIds)
            ->with('student')
            ->get();

        // Mahasiswa dengan persentase kehadiran (hadir+terlambat) tertinggi.
        $bestAttendance = \App\Models\Internship::whereIn('id', $internshipIds)
            ->withCount([
                'attendances as total_attendance_count',
                'attendances as present_attendance_count' => fn ($q) => $q->whereIn('status', ['hadir', 'terlambat']),
            ])
            ->having('total_attendance_count', '>', 0)
            ->with('student')
            ->get()
            ->map(function ($internship) {
                $internship->attendance_rate = (int) round(
                    ($internship->present_attendance_count / $internship->total_attendance_count) * 100
                );

                return $internship;
            })
            ->sortByDesc('attendance_rate')
            ->take(5)
            ->values();

        return view('dashboard.mentor', [
            'stats' => $stats,
            'recentAttendances' => $recentAttendances,
            'activePeriods' => $activePeriods,
            'notYetAttendedToday' => $notYetAttendedToday,
            'bestAttendance' => $bestAttendance,
        ]);
    }
}
