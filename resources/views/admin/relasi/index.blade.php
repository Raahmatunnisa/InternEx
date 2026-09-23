@extends('layouts.app')
@section('title', 'Relasi Mahasiswa-Mentor')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-slate-900">Relasi Mahasiswa-Mentor</h1>
    <p class="text-slate-500 mt-1">Tentukan atau ubah mentor pembimbing untuk setiap mahasiswa.</p>
</div>

<form method="GET" class="flex flex-wrap items-end gap-3 mb-5">
    <div class="w-64">
        <x-input name="search" label="Cari nama mahasiswa" :value="request('search')" placeholder="Cari mahasiswa..." />
    </div>
    <div class="w-56">
        <x-select name="mentor_id" label="Filter Mentor" :options="$mentors->pluck('name', 'id')" :selected="request('mentor_id')" placeholder="Semua Mentor" />
    </div>
    <button type="submit" class="btn btn-secondary">
        <i data-lucide="filter" class="w-4 h-4"></i> Filter
    </button>
</form>

@if($internships->isEmpty())
    <x-empty-state title="Belum ada data magang" description="Data akan muncul setelah mahasiswa memiliki penempatan magang." icon="git-branch" />
@else
    <form method="POST" action="{{ route('admin.relasi.bulk-update') }}">
        @csrf @method('PUT')
        <x-card class="!p-0 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-slate-50 border-b border-slate-200">
                        <tr class="text-left text-slate-500 text-xs uppercase">
                            <th class="px-5 py-3 font-medium">Mahasiswa</th>
                            <th class="px-5 py-3 font-medium">Periode</th>
                            <th class="px-5 py-3 font-medium">Mentor Saat Ini</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($internships as $internship)
                            <tr class="hover:bg-slate-50">
                                <td class="px-5 py-3.5 font-medium text-slate-800">{{ $internship->student->name }}</td>
                                <td class="px-5 py-3.5 text-slate-600">{{ $internship->period->name ?? '-' }}</td>
                                <td class="px-5 py-3.5">
                                    <select name="assignments[{{ $internship->id }}]" class="form-select !py-1.5 !text-sm w-48" required>
                                        @foreach($mentors as $mentor)
                                            <option value="{{ $mentor->id }}" @selected($internship->mentor_id === $mentor->id)>{{ $mentor->name }}</option>
                                        @endforeach
                                    </select>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </x-card>
        <div class="mt-6 flex justify-end">
            <button type="submit" class="btn btn-primary">
                <i data-lucide="check" class="w-4 h-4"></i> Simpan Semua
            </button>
        </div>
    </form>
    <div class="mt-6">{{ $internships->links() }}</div>
@endif
@endsection
