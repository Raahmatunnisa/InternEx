<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Internship;
use App\Models\InternshipPeriod;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $stats = [
            'total_mahasiswa' => User::where('role', 'mahasiswa')->count(),
            'total_mentor' => User::where('role', 'mentor')->count(),
            'total_admin' => User::where('role', 'admin')->count(),
            'total_internship' => Internship::count(),
            'active_internship' => Internship::where('status', 'active')->count(),
            'inactive_internship' => Internship::where('status', '!=', 'active')->count(),
            'active_period' => InternshipPeriod::where('status', 'active')->count(),
            'total_attendance' => Attendance::count(),
        ];

        $attendanceToday = [
            'hadir' => Attendance::whereDate('date', today())->where('status', 'hadir')->count(),
            'terlambat' => Attendance::whereDate('date', today())->where('status', 'terlambat')->count(),
            'izin' => Attendance::whereDate('date', today())->where('status', 'izin')->count(),
            'sakit' => Attendance::whereDate('date', today())->where('status', 'sakit')->count(),
            'alpha' => Attendance::whereDate('date', today())->where('status', 'alpha')->count(),
        ];

        $activePeriods = InternshipPeriod::where('status', 'active')->withCount('internships')->get();

        $recentMahasiswa = User::where('role', 'mahasiswa')->latest()->limit(5)->get();

        return view('admin.dashboard', [
            'stats' => $stats,
            'attendanceToday' => $attendanceToday,
            'activePeriods' => $activePeriods,
            'recentMahasiswa' => $recentMahasiswa,
        ]);
    }
}
