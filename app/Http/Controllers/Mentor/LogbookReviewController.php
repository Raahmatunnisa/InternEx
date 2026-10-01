<?php

namespace App\Http\Controllers\Mentor;

use App\Http\Controllers\Controller;
use App\Http\Requests\ReviewLogbookRequest;
use App\Models\Logbook;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LogbookReviewController extends Controller
{
    public function index(Request $request): View
    {
        $studentIds = $request->user()->studentInternships()->pluck('id');

        $logbooks = Logbook::whereIn('internship_id', $studentIds)
            ->with(['internship.student'])
            ->when($request->filled('status'), fn ($q) => $q->where('status', $request->string('status')))
            ->when($request->filled('date_from'), fn ($q) => $q->whereDate('date', '>=', $request->date('date_from')))
            ->when($request->filled('date_to'), fn ($q) => $q->whereDate('date', '<=', $request->date('date_to')))
            ->latest('date')
            ->paginate(10)
            ->withQueryString();

        return view('mentor.logbook-reviews.index', ['logbooks' => $logbooks]);
    }

    public function show(Logbook $logbook): View
    {
        $this->authorize('review', $logbook);

        $logbook->load(['internship.student', 'feedbacks.mentor']);

        return view('mentor.logbook-reviews.show', ['logbook' => $logbook]);
    }

    public function approve(ReviewLogbookRequest $request, Logbook $logbook): RedirectResponse
    {
        $logbook->update(['status' => 'approved']);

        if ($request->filled('feedback')) {
            $logbook->feedbacks()->create([
                'mentor_id' => $request->user()->id,
                'feedback' => $request->string('feedback'),
            ]);
        }

        return redirect()->route('logbook-reviews.index')->with('success', 'Logbook berhasil disetujui.');
    }

    public function reject(ReviewLogbookRequest $request, Logbook $logbook): RedirectResponse
    {
        $logbook->update(['status' => 'rejected']);

        $logbook->feedbacks()->create([
            'mentor_id' => $request->user()->id,
            'feedback' => $request->string('feedback'),
        ]);

        return redirect()->route('logbook-reviews.index')->with('success', 'Logbook berhasil ditolak dengan feedback.');
    }
}
