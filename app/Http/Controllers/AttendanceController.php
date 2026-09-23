<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AttendanceController extends Controller
{
    public function index(Request $request): View
    {
        $internship = $request->user()->internship;

        abort_if(! $internship, 403, 'Anda belum memiliki data magang aktif.');

        $attendances = $internship->attendances()
            ->when($request->filled('month'), function ($q) use ($request) {
                $q->whereMonth('date', substr($request->string('month'), 5, 2))
                    ->whereYear('date', substr($request->string('month'), 0, 4));
            })
            ->latest('date')
            ->paginate(15)
            ->withQueryString();

        $todayAttendance = $internship->attendances()->whereDate('date', today())->first();

        $summary = [
            'hadir' => (clone $internship->attendances())->where('status', 'hadir')->count(),
            'terlambat' => (clone $internship->attendances())->where('status', 'terlambat')->count(),
            'izin' => (clone $internship->attendances())->where('status', 'izin')->count(),
            'sakit' => (clone $internship->attendances())->where('status', 'sakit')->count(),
            'alpha' => (clone $internship->attendances())->where('status', 'alpha')->count(),
        ];

        return view('attendances.index', [
            'attendances' => $attendances,
            'todayAttendance' => $todayAttendance,
            'summary' => $summary,
        ]);
    }

    public function checkIn(Request $request): RedirectResponse
    {
        $internship = $request->user()->internship;

        abort_if(! $internship, 403, 'Anda belum memiliki data magang aktif.');

        $existing = $internship->attendances()->whereDate('date', today())->first();

        if ($existing) {
            return back()->with('error', 'Anda sudah melakukan absen masuk hari ini.');
        }

        $now = now();
        $onTimeLimit = $now->copy()->setTimeFromTimeString(config('app.attendance_on_time_limit', '09:00'));

        $internship->attendances()->create([
            'date' => today(),
            'check_in_time' => $now->format('H:i:s'),
            'status' => $now->greaterThan($onTimeLimit) ? 'terlambat' : 'hadir',
        ]);

        return back()->with('success', 'Absen masuk berhasil dicatat.');
    }

    public function checkOut(Request $request): RedirectResponse
    {
        $internship = $request->user()->internship;

        abort_if(! $internship, 403, 'Anda belum memiliki data magang aktif.');

        $attendance = $internship->attendances()->whereDate('date', today())->first();

        if (! $attendance || ! $attendance->check_in_time) {
            return back()->with('error', 'Anda belum melakukan absen masuk hari ini.');
        }

        if ($attendance->check_out_time) {
            return back()->with('error', 'Anda sudah melakukan absen pulang hari ini.');
        }

        $attendance->update(['check_out_time' => now()->format('H:i:s')]);

        return back()->with('success', 'Absen pulang berhasil dicatat.');
    }
}
