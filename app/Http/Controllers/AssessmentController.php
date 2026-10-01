<?php

namespace App\Http\Controllers;

use App\Models\Assessment;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AssessmentController extends Controller
{
    /**
     * Mahasiswa hanya dapat melihat nilai miliknya sendiri; tidak ada
     * parameter route sehingga tidak mungkin mengakses nilai mahasiswa lain.
     */
    public function show(Request $request): View
    {
        $internship = $request->user()->internship;

        abort_if(! $internship, 403, 'Anda belum memiliki data magang aktif.');

        $assessment = $internship->assessment;

        return view('assessment.show', [
            'assessment' => $assessment,
            'weights' => [
                'attendance' => Assessment::WEIGHT_ATTENDANCE * 100,
                'logbook' => Assessment::WEIGHT_LOGBOOK * 100,
                'final_report' => Assessment::WEIGHT_FINAL_REPORT * 100,
                'presentation' => Assessment::WEIGHT_PRESENTATION * 100,
            ],
        ]);
    }
}
