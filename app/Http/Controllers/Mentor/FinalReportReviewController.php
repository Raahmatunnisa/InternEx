<?php

namespace App\Http\Controllers\Mentor;

use App\Http\Controllers\Controller;
use App\Http\Requests\ReviewFinalReportRequest;
use App\Models\FinalReport;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class FinalReportReviewController extends Controller
{
    public function index(Request $request): View
    {
        $studentIds = $request->user()->studentInternships()->pluck('id');

        $finalReports = FinalReport::whereIn('internship_id', $studentIds)
            ->whereIn('status', ['submitted', 'reviewed', 'approved', 'revision'])
            ->with('internship.student')
            ->latest()
            ->paginate(10);

        return view('mentor.final-reports.index', ['finalReports' => $finalReports]);
    }

    public function show(FinalReport $finalReport): View
    {
        $this->authorize('review', $finalReport);

        $finalReport->load(['internship.student', 'feedbacks.mentor']);

        return view('mentor.final-reports.show', ['finalReport' => $finalReport]);
    }

    /**
     * Tampilkan file laporan akhir di tab baru (preview inline), bukan
     * download paksa. Hanya mentor pembimbing mahasiswa terkait yang
     * dapat mengakses (lihat FinalReportPolicy::view).
     */
    public function preview(FinalReport $finalReport)
    {
        $this->authorize('view', $finalReport);

        abort_if(! $finalReport->file_path, 404, 'Belum ada file laporan yang diunggah.');
        abort_unless(Storage::disk('local')->exists($finalReport->file_path), 404);

        return Storage::disk('local')->response($finalReport->file_path);
    }

    public function review(ReviewFinalReportRequest $request, FinalReport $finalReport): RedirectResponse
    {
        $finalReport->update(['status' => 'reviewed']);

        if ($request->filled('feedback')) {
            $finalReport->feedbacks()->create([
                'mentor_id' => $request->user()->id,
                'feedback' => $request->string('feedback'),
            ]);
        }

        return redirect()->route('final-reports.index')->with('success', 'Laporan berhasil ditandai sebagai direview.');
    }

    public function approve(ReviewFinalReportRequest $request, FinalReport $finalReport): RedirectResponse
    {
        $finalReport->update(['status' => 'approved']);

        if ($request->filled('feedback')) {
            $finalReport->feedbacks()->create([
                'mentor_id' => $request->user()->id,
                'feedback' => $request->string('feedback'),
            ]);
        }

        return redirect()->route('final-reports.index')->with('success', 'Laporan akhir berhasil disetujui.');
    }

    public function requestRevision(ReviewFinalReportRequest $request, FinalReport $finalReport): RedirectResponse
    {
        $finalReport->update(['status' => 'revision']);

        $finalReport->feedbacks()->create([
            'mentor_id' => $request->user()->id,
            'feedback' => $request->string('feedback'),
        ]);

        return redirect()->route('final-reports.index')->with('success', 'Revisi laporan berhasil diminta.');
    }
}
