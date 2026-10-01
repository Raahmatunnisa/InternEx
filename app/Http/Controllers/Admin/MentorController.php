<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreMentorRequest;
use App\Http\Requests\Admin\UpdateMentorRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class MentorController extends Controller
{
    public function index(Request $request): View
    {
        $mentors = User::query()
            ->where('role', 'mentor')
            ->withCount('studentInternships')
            ->when($request->filled('search'), fn ($q) => $q->where(fn ($q2) => $q2
                ->where('name', 'like', '%'.$request->string('search').'%')
                ->orWhere('email', 'like', '%'.$request->string('search').'%')))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.mentor.index', ['mentors' => $mentors]);
    }

    public function create(): View
    {
        return view('admin.mentor.create');
    }

    public function store(StoreMentorRequest $request): RedirectResponse
    {
        $data = $request->validated();

        User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'] ?? null,
            'password' => Hash::make($data['password']),
            'role' => 'mentor',
            'is_active' => $request->boolean('is_active', true),
        ]);

        return redirect()->route('admin.mentor.index')->with('success', 'Akun mentor berhasil dibuat.');
    }

    public function edit(User $mentor): View
    {
        abort_unless($mentor->role === 'mentor', 404);

        return view('admin.mentor.edit', ['mentor' => $mentor]);
    }

    public function update(UpdateMentorRequest $request, User $mentor): RedirectResponse
    {
        abort_unless($mentor->role === 'mentor', 404);

        $data = $request->validated();

        $mentor->fill([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'] ?? null,
            'is_active' => $request->boolean('is_active', true),
        ]);

        if (! empty($data['password'])) {
            $mentor->password = Hash::make($data['password']);
        }

        $mentor->save();

        return redirect()->route('admin.mentor.index')->with('success', 'Data mentor berhasil diperbarui.');
    }

    public function toggleActive(User $mentor): RedirectResponse
    {
        abort_unless($mentor->role === 'mentor', 404);

        $mentor->update(['is_active' => ! $mentor->is_active]);

        return back()->with('success', $mentor->is_active ? 'Akun mentor diaktifkan.' : 'Akun mentor dinonaktifkan.');
    }

    public function destroy(User $mentor): RedirectResponse
    {
        abort_unless($mentor->role === 'mentor', 404);

        if ($mentor->studentInternships()->exists()) {
            return back()->with('error', 'Mentor tidak dapat dihapus karena masih membimbing mahasiswa. Pindahkan mahasiswa bimbingan ke mentor lain terlebih dahulu.');
        }

        $mentor->delete();

        return redirect()->route('admin.mentor.index')->with('success', 'Akun mentor berhasil dihapus.');
    }
}
