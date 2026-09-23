<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreMahasiswaRequest;
use App\Http\Requests\Admin\UpdateMahasiswaRequest;
use App\Models\Division;
use App\Models\InternshipPeriod;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class MahasiswaController extends Controller
{
    public function index(Request $request): View
    {
        $mahasiswa = User::query()
            ->where('role', 'mahasiswa')
            ->with(['internship.mentor', 'internship.period', 'internship.division'])
            ->when($request->filled('search'), fn ($q) => $q->where(fn ($q2) => $q2
                ->where('name', 'like', '%'.$request->string('search').'%')
                ->orWhere('email', 'like', '%'.$request->string('search').'%')))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.mahasiswa.index', ['mahasiswa' => $mahasiswa]);
    }

    public function create(): View
    {
        return view('admin.mahasiswa.create', $this->formOptions());
    }

    public function store(StoreMahasiswaRequest $request): RedirectResponse
    {
        $data = $request->validated();

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'] ?? null,
            'password' => Hash::make($data['password']),
            'role' => 'mahasiswa',
            'is_active' => $request->boolean('is_active', true),
        ]);

        if (! empty($data['mentor_id']) && ! empty($data['internship_period_id'])) {
            $user->internship()->create([
                'mentor_id' => $data['mentor_id'],
                'internship_period_id' => $data['internship_period_id'],
                'division_id' => $data['division_id'] ?? null,
                'institution' => $data['institution'] ?? '-',
                'program' => $data['program'] ?? '-',
                'start_date' => $data['start_date'],
                'end_date' => $data['end_date'] ?? $data['start_date'],
                'status' => 'active',
            ]);
        }

        return redirect()->route('admin.mahasiswa.index')->with('success', 'Akun mahasiswa berhasil dibuat.');
    }

    public function edit(User $mahasiswa): View
    {
        abort_unless($mahasiswa->role === 'mahasiswa', 404);

        $mahasiswa->load('internship');

        return view('admin.mahasiswa.edit', array_merge(
            ['mahasiswa' => $mahasiswa],
            $this->formOptions()
        ));
    }

    public function update(UpdateMahasiswaRequest $request, User $mahasiswa): RedirectResponse
    {
        abort_unless($mahasiswa->role === 'mahasiswa', 404);

        $data = $request->validated();

        $mahasiswa->fill([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'] ?? null,
            'is_active' => $request->boolean('is_active', true),
        ]);

        if (! empty($data['password'])) {
            $mahasiswa->password = Hash::make($data['password']);
        }

        $mahasiswa->save();

        if (! empty($data['mentor_id']) && ! empty($data['internship_period_id'])) {
            $mahasiswa->internship()->updateOrCreate(
                ['user_id' => $mahasiswa->id],
                [
                    'mentor_id' => $data['mentor_id'],
                    'internship_period_id' => $data['internship_period_id'],
                    'division_id' => $data['division_id'] ?? null,
                    'institution' => $data['institution'] ?? ($mahasiswa->internship->institution ?? '-'),
                    'program' => $data['program'] ?? ($mahasiswa->internship->program ?? '-'),
                    'start_date' => $data['start_date'],
                    'end_date' => $data['end_date'] ?? $data['start_date'],
                    'status' => $data['internship_status'] ?? ($mahasiswa->internship->status ?? 'active'),
                ]
            );
        }

        return redirect()->route('admin.mahasiswa.index')->with('success', 'Data mahasiswa berhasil diperbarui.');
    }

    public function toggleActive(User $mahasiswa): RedirectResponse
    {
        abort_unless($mahasiswa->role === 'mahasiswa', 404);

        $mahasiswa->update(['is_active' => ! $mahasiswa->is_active]);

        return back()->with('success', $mahasiswa->is_active ? 'Akun mahasiswa diaktifkan.' : 'Akun mahasiswa dinonaktifkan.');
    }

    public function destroy(User $mahasiswa): RedirectResponse
    {
        abort_unless($mahasiswa->role === 'mahasiswa', 404);

        $mahasiswa->delete();

        return redirect()->route('admin.mahasiswa.index')->with('success', 'Akun mahasiswa berhasil dihapus.');
    }

    protected function formOptions(): array
    {
        return [
            'mentors' => User::where('role', 'mentor')->orderBy('name')->get(),
            'periods' => InternshipPeriod::orderByDesc('start_date')->get(),
            'divisions' => Division::orderBy('name')->get(),
        ];
    }
}
