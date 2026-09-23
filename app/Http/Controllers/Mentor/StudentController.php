<?php

namespace App\Http\Controllers\Mentor;

use App\Http\Controllers\Controller;
use App\Models\Internship;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StudentController extends Controller
{
    public function index(Request $request): View
    {
        $internships = $request->user()->studentInternships()
            ->with(['student', 'period', 'division'])
            ->withCount('logbooks')
            ->latest()
            ->paginate(10);

        return view('mentor.students.index', ['internships' => $internships]);
    }

    public function show(Internship $student): View
    {
        $this->authorize('view', $student);

        $student->load(['student', 'period', 'division', 'finalReport']);

        $logbooks = $student->logbooks()->latest('date')->limit(10)->get();
        $attendanceCount = $student->attendances()->whereIn('status', ['hadir', 'terlambat'])->count();
        $totalDays = max($student->start_date->diffInDays(min(now(), $student->end_date)) + 1, 1);
        $attendanceRate = min(100, (int) round(($attendanceCount / $totalDays) * 100));

        return view('mentor.students.show', [
            'internship' => $student,
            'logbooks' => $logbooks,
            'attendanceRate' => $attendanceRate,
        ]);
    }
}
