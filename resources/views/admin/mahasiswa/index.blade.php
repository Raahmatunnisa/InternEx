@extends('layouts.app')
@section('title', 'Kelola Mahasiswa')

@section('content')
<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
    <div>
        <h1 class="text-2xl font-bold text-slate-900">Kelola Mahasiswa</h1>
        <p class="text-slate-500 mt-1">Buat, lihat, dan kelola akun mahasiswa beserta penempatan magangnya.</p>
    </div>
    <a href="{{ route('admin.mahasiswa.create') }}" class="btn btn-primary">
        <i data-lucide="plus" class="w-4 h-4"></i> Tambah Mahasiswa
    </a>
</div>

<form method="GET" class="flex flex-wrap items-end gap-3 mb-5">
    <div class="w-64">
        <x-input name="search" label="Cari nama/email" :value="request('search')" placeholder="Cari mahasiswa..." />
    </div>
    <button type="submit" class="btn btn-secondary">
        <i data-lucide="search" class="w-4 h-4"></i> Cari
    </button>
</form>

@if($mahasiswa->isEmpty())
    <x-empty-state title="Belum ada mahasiswa" description="Tambahkan akun mahasiswa baru melalui tombol di atas." icon="graduation-cap" />
@else
    <x-card class="!p-0 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-slate-50 border-b border-slate-200">
                    <tr class="text-left text-slate-500 text-xs uppercase">
                        <th class="px-5 py-3 font-medium">Nama</th>
                        <th class="px-5 py-3 font-medium">Mentor</th>
                        <th class="px-5 py-3 font-medium">Periode</th>
                        <th class="px-5 py-3 font-medium">Divisi / Tim Kerja</th>
                        <th class="px-5 py-3 font-medium">Status</th>
                        <th class="px-5 py-3 font-medium text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($mahasiswa as $mhs)
                        <tr class="hover:bg-slate-50">
                            <td class="px-5 py-3.5">
                                <p class="font-medium text-slate-800">{{ $mhs->name }}</p>
                                <p class="text-xs text-slate-400">{{ $mhs->email }}</p>
                            </td>
                            <td class="px-5 py-3.5 text-slate-600">{{ $mhs->internship->mentor->name ?? '-' }}</td>
                            <td class="px-5 py-3.5 text-slate-600">{{ $mhs->internship->period->name ?? '-' }}</td>
                            <td class="px-5 py-3.5 text-slate-600">
                                {{ $mhs->internship->division->name ?? '-' }}
                            </td>
                            <td class="px-5 py-3.5">
                                <x-badge :status="$mhs->is_active ? 'active' : 'rejected'">{{ $mhs->is_active ? 'Aktif' : 'Nonaktif' }}</x-badge>
                            </td>
                            <td class="px-5 py-3.5 text-right">
                                <div class="flex items-center justify-end gap-3">
                                    <a href="{{ route('admin.mahasiswa.edit', $mhs) }}" class="text-indigo-600 hover:underline font-medium">Edit</a>
                                    <form method="POST" action="{{ route('admin.mahasiswa.toggle-active', $mhs) }}">
                                        @csrf
                                        <button type="submit" class="text-amber-500 hover:text-amber-600 hover:underline font-medium">{{ $mhs->is_active ? 'Nonaktifkan' : 'Aktifkan' }}</button>
                                    </form>
                                    <form method="POST" action="{{ route('admin.mahasiswa.destroy', $mhs) }}" onsubmit="return confirm('Hapus akun mahasiswa {{ $mhs->name }}? Tindakan ini tidak dapat dibatalkan.')">
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
    <div class="mt-6">{{ $mahasiswa->links() }}</div>
@endif
@endsection
