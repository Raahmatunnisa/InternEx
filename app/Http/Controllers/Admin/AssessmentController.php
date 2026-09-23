<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Assessment;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AssessmentController extends Controller
{
    /**
     * Admin dapat melihat seluruh data penilaian mahasiswa untuk monitoring.
     * Hak akses fitur existing lainnya tidak diubah.
     */
    public function index(): View
    {
        $assessments = Assessment::with(['internship.student', 'internship.mentor', 'internship.period'])
            ->latest()
            ->paginate(15);

        return view('admin.assessments.index', ['assessments' => $assessments]);
    }

    /**
     * Dokumen cetak nilai untuk satu mahasiswa. Dipakai untuk dua mode:
     * - Preview: dibuka di tab baru, admin bisa mencetak manual lewat toolbar.
     * - Unduh: halaman yang sama, tapi otomatis membuka dialog cetak browser
     *   (Simpan sebagai PDF) begitu halaman selesai dimuat.
     */
    public function document(Assessment $assessment, Request $request): View
    {
        $assessment->load(['internship.student', 'internship.mentor', 'internship.period']);

        return view('admin.assessments.document', [
            'assessment' => $assessment,
            'autoPrint' => $request->boolean('unduh'),
        ]);
    }
}
