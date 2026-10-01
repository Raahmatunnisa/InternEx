@extends('layouts.app')
@section('title', 'Bagian/Divisi')

@section('content')
<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
    <div>
        <h1 class="text-2xl font-bold text-slate-900">Divisi/Tim Kerja</h1>
        <p class="text-slate-500 mt-1">Kelola daftar divisi/tim kerja tempat penempatan mahasiswa magang.</p>
    </div>
    <button type="button" onclick="toggleModal('create-division-modal')" class="btn btn-primary">
        <i data-lucide="plus" class="w-4 h-4"></i> Tambah Divisi
    </button>
</div>

@if($divisions->isEmpty())
    <x-empty-state title="Belum ada bagian/divisi" description="Tambahkan bagian/divisi baru melalui tombol di atas." icon="building-2" />
@else
    <x-card class="!p-0 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-slate-50 border-b border-slate-200">
                    <tr class="text-left text-slate-500 text-xs uppercase">
                        <th class="px-5 py-3 font-medium">Nama Divisi</th>
                        <th class="px-5 py-3 font-medium">Deskripsi</th>
                        <th class="px-5 py-3 font-medium">Jumlah Mahasiswa</th>
                        <th class="px-5 py-3 font-medium text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($divisions as $division)
                        <tr class="hover:bg-slate-50">
                            <td class="px-5 py-3.5 font-medium text-slate-800">{{ $division->name }}</td>
                            <td class="px-5 py-3.5 text-slate-600">{{ $division->description ?? '-' }}</td>
                            <td class="px-5 py-3.5 text-slate-600">{{ $division->internships_count }}</td>
                            <td class="px-5 py-3.5 text-right">
                                <div class="flex items-center justify-end gap-3">
                                    <button type="button" onclick="toggleModal('edit-division-{{ $division->id }}')" class="text-indigo-600 hover:underline font-medium">Edit</button>
                                    <form method="POST" action="{{ route('admin.divisions.destroy', $division) }}" onsubmit="return confirm('Hapus bagian {{ $division->name }}?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:underline font-medium">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>

                        <x-modal id="edit-division-{{ $division->id }}" title="Edit Bagian">
                            <form method="POST" action="{{ route('admin.divisions.update', $division) }}">
                                @csrf @method('PUT')
                                <div class="space-y-4">
                                    <x-input name="name" label="Nama Bagian" :value="$division->name" required />
                                    <x-textarea name="description" label="Deskripsi" rows="2">{{ $division->description }}</x-textarea>
                                </div>
                                <div class="flex gap-3 mt-5">
                                    <button type="button" onclick="toggleModal('edit-division-{{ $division->id }}')" class="btn btn-secondary flex-1">Batal</button>
                                    <button type="submit" class="btn btn-primary flex-1">Simpan</button>
                                </div>
                            </form>
                        </x-modal>
                    @endforeach
                </tbody>
            </table>
        </div>
    </x-card>
    <div class="mt-6">{{ $divisions->links() }}</div>
@endif

<x-modal id="create-division-modal" title="Tambah Bagian/Divisi">
    <form method="POST" action="{{ route('admin.divisions.store') }}">
        @csrf
        <div class="space-y-4">
            <x-input name="name" label="Nama Bagian" required placeholder="Contoh: IT Development" />
            <x-textarea name="description" label="Deskripsi (opsional)" rows="2" />
        </div>
        <div class="flex gap-3 mt-5">
            <button type="button" onclick="toggleModal('create-division-modal')" class="btn btn-secondary flex-1">Batal</button>
            <button type="submit" class="btn btn-primary flex-1">Simpan</button>
        </div>
    </form>
</x-modal>
@endsection
