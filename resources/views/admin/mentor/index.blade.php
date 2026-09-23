@extends('layouts.app')
@section('title', 'Kelola Mentor')

@section('content')
<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
    <div>
        <h1 class="text-2xl font-bold text-slate-900">Kelola Mentor</h1>
        <p class="text-slate-500 mt-1">Buat, lihat, dan kelola akun mentor pembimbing.</p>
    </div>
    <a href="{{ route('admin.mentor.create') }}" class="btn btn-primary">
        <i data-lucide="plus" class="w-4 h-4"></i> Tambah Mentor
    </a>
</div>

<form method="GET" class="flex flex-wrap items-end gap-3 mb-5">
    <div class="w-64">
        <x-input name="search" label="Cari nama/email" :value="request('search')" placeholder="Cari mentor..." />
    </div>
    <button type="submit" class="btn btn-secondary">
        <i data-lucide="search" class="w-4 h-4"></i> Cari
    </button>
</form>

@if($mentors->isEmpty())
    <x-empty-state title="Belum ada mentor" description="Tambahkan akun mentor baru melalui tombol di atas." icon="user-check" />
@else
    <x-card class="!p-0 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-slate-50 border-b border-slate-200">
                    <tr class="text-left text-slate-500 text-xs uppercase">
                        <th class="px-5 py-3 font-medium">Nama</th>
                        <th class="px-5 py-3 font-medium">Mahasiswa Bimbingan</th>
                        <th class="px-5 py-3 font-medium">Status</th>
                        <th class="px-5 py-3 font-medium text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($mentors as $mentor)
                        <tr class="hover:bg-slate-50">
                            <td class="px-5 py-3.5">
                                <p class="font-medium text-slate-800">{{ $mentor->name }}</p>
                                <p class="text-xs text-slate-400">{{ $mentor->email }}</p>
                            </td>
                            <td class="px-5 py-3.5 text-slate-600">{{ $mentor->student_internships_count }} mahasiswa</td>
                            <td class="px-5 py-3.5">
                                <x-badge :status="$mentor->is_active ? 'active' : 'rejected'">{{ $mentor->is_active ? 'Aktif' : 'Nonaktif' }}</x-badge>
                            </td>
                            <td class="px-5 py-3.5 text-right">
                                <div class="flex items-center justify-end gap-3">
                                    <a href="{{ route('admin.mentor.edit', $mentor) }}" class="text-indigo-600 hover:underline font-medium">Edit</a>
                                    <form method="POST" action="{{ route('admin.mentor.toggle-active', $mentor) }}">
                                        @csrf
                                        <button type="submit" class="text-amber-500 hover:text-amber-600 hover:underline font-medium">{{ $mentor->is_active ? 'Nonaktifkan' : 'Aktifkan' }}</button>
                                    </form>
                                    <form method="POST" action="{{ route('admin.mentor.destroy', $mentor) }}" onsubmit="return confirm('Hapus akun mentor {{ $mentor->name }}?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:underline font-medium">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </x-card>
    <div class="mt-6">{{ $mentors->links() }}</div>
@endif
@endsection
