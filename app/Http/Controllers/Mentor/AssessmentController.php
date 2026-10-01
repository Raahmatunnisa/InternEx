<?php

namespace App\Http\Controllers\Mentor;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAssessmentRequest;
use App\Models\Internship;
use Illuminate\Http\RedirectResponse;

class AssessmentController extends Controller
{
    /**
     * Simpan nilai baru atau perbarui nilai yang sudah ada (upsert) untuk
     * mahasiswa bimbingan mentor yang login. Otorisasi: hanya mentor
     * pembimbing mahasiswa terkait (lihat InternshipPolicy::assess).
     */
    public function store(StoreAssessmentRequest $request, Internship $student): RedirectResponse
    {
        $student->assessment()->updateOrCreate(
            ['internship_id' => $student->id],
            [
                'mentor_id' => $request->user()->id,
                ...$request->validated(),
            ]
        );

        return redirect()->route('students.show', $student)
            ->with('success', 'Penilaian mahasiswa berhasil disimpan.');
    }
}
