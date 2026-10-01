<?php

namespace App\Http\Controllers\Mentor;

use App\Http\Controllers\Controller;
use App\Http\Requests\ReviewPermitRequest;
use App\Models\Permit;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class PermitController extends Controller
{
    public function index(Request $request): View
    {
        $studentIds = $request->user()->studentInternships()->pluck('id');

        $permits = Permit::whereIn('internship_id', $studentIds)
            ->with('internship.student')
            ->latest('start_date')
            ->paginate(10);

        return view('mentor.permits.index', ['permits' => $permits]);
    }

    public function show(Permit $permit): View
    {
        $this->authorize('view', $permit);

        $permit->load(['internship.student']);

        return view('mentor.permits.show', ['permit' => $permit]);
    }

    public function approve(ReviewPermitRequest $request, Permit $permit): RedirectResponse
    {
        $this->authorize('review', $permit);

        $permit->update([
            'status' => 'approved',
            'review_note' => $request->input('review_note'),
            'reviewed_by' => $request->user()->id,
            'reviewed_at' => now(),
        ]);

        return redirect()->route('permits-review.index')->with('success', 'Pengajuan izin berhasil disetujui.');
    }

    public function reject(ReviewPermitRequest $request, Permit $permit): RedirectResponse
    {
        $this->authorize('review', $permit);

        $permit->update([
            'status' => 'rejected',
            'review_note' => $request->input('review_note'),
            'reviewed_by' => $request->user()->id,
            'reviewed_at' => now(),
        ]);

        return redirect()->route('permits-review.index')->with('success', 'Pengajuan izin berhasil ditolak.');
    }

    /**
     * Tampilkan dokumen pendukung di tab baru (preview), bukan download
     * paksa. Hanya mentor pembimbing mahasiswa terkait yang dapat membuka.
     */
    public function attachment(Permit $permit)
    {
        $this->authorize('view', $permit);

        abort_if(! $permit->attachment_path, 404);
        abort_unless(Storage::disk('local')->exists($permit->attachment_path), 404);

        return Storage::disk('local')->response($permit->attachment_path);
    }
}
