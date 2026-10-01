<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AssignMentorRequest;
use App\Http\Requests\Admin\BulkAssignMentorRequest;
use App\Models\Internship;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class StudentMentorController extends Controller
{
    public function index(Request $request): View
    {
        $internships = Internship::query()
            ->with(['student', 'mentor', 'period'])
            ->when($request->filled('mentor_id'), fn ($q) => $q->where('mentor_id', $request->input('mentor_id')))
            ->when($request->filled('search'), fn ($q) => $q->whereHas('student', fn ($q2) => $q2
                ->where('name', 'like', '%'.$request->string('search').'%')))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $mentors = User::where('role', 'mentor')->orderBy('name')->get();

        return view('admin.relasi.index', ['internships' => $internships, 'mentors' => $mentors]);
    }

    public function update(AssignMentorRequest $request, Internship $internship): RedirectResponse
    {
        $this->authorize('update', $internship);

        $internship->update(['mentor_id' => $request->validated()['mentor_id']]);

        return back()->with('success', "Mentor pembimbing {$internship->student->name} berhasil diperbarui.");
    }

    /**
     * Simpan seluruh perubahan mentor pembimbing untuk semua mahasiswa yang
     * tampil di tabel (halaman aktif) sekaligus, dalam satu kali submit.
     */
    public function bulkUpdate(BulkAssignMentorRequest $request): RedirectResponse
    {
        $assignments = $request->validated()['assignments'];

        $internships = Internship::whereIn('id', array_keys($assignments))->get();

        foreach ($internships as $internship) {
            $this->authorize('update', $internship);
        }

        DB::transaction(function () use ($internships, $assignments) {
            foreach ($internships as $internship) {
                $internship->update(['mentor_id' => $assignments[$internship->id]]);
            }
        });

        return back()->with('success', 'Mentor pembimbing untuk seluruh mahasiswa berhasil diperbarui.');
    }
}
