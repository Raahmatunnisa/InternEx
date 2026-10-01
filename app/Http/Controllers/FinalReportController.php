<?php

namespace App\Http\Controllers;

use App\Http\Requests\SubmitFinalReportRequest;
use App\Http\Requests\UpdateFinalReportRequest;
use App\Models\FinalReport;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class FinalReportController extends Controller
{
    public function show(Request $request): View
    {
        $internship = $request->user()->internship;

        abort_if(! $internship, 403, 'Anda belum memiliki data magang aktif.');

        $finalReport = $internship->finalReport;

        if (! $finalReport) {
            $finalReport = $internship->finalReport()->create(['status' => 'draft']);
        }

        $finalReport->load('feedbacks.mentor');

        return view('final-report.show', ['finalReport' => $finalReport]);
    }

    public function update(UpdateFinalReportRequest $request, FinalReport $finalReport): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('file')) {
            if ($finalReport->file_path) {
                Storage::disk('local')->delete($finalReport->file_path);
            }
            $data['file_path'] = $request->file('file')->store('reports', 'local');
        }

        if ($finalReport->status === 'revision') {
            $data['status'] = 'revision';
        }

        $finalReport->update($data);

        return redirect()->route('final-report.show')->with('success', 'Laporan akhir berhasil disimpan.');
    }

    public function submit(SubmitFinalReportRequest $request, FinalReport $finalReport): RedirectResponse
    {
        $finalReport->update(['status' => 'submitted']);

        return redirect()->route('final-report.show')->with('success', 'Laporan akhir berhasil dikirim untuk direview mentor.');
    }

    /**
     * Tampilkan file laporan akhir di tab baru (preview inline), bukan
     * download paksa. Hanya pemilik laporan atau mentor pembimbingnya
     * (lihat FinalReportPolicy::view) yang dapat mengakses.
     */
    public function preview(FinalReport $finalReport)
    {
        $this->authorize('view', $finalReport);

        abort_if(! $finalReport->file_path, 404, 'Belum ada file laporan yang diunggah.');
        abort_unless(Storage::disk('local')->exists($finalReport->file_path), 404);

        return Storage::disk('local')->response($finalReport->file_path);
    }
}

