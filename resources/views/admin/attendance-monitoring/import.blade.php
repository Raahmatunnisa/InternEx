@extends('layouts.app')
@section('title', 'Import Kehadiran')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.attendance-monitoring.index') }}" class="text-sm text-slate-500 hover:text-slate-700 flex items-center gap-1 mb-2">
        <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali ke Monitoring Kehadiran
    </a>
    <h1 class="text-2xl font-bold text-slate-900">Import Data Kehadiran</h1>
    <p class="text-slate-500 mt-1">Unggah file Excel (.xlsx) hasil rekap presensi untuk disimpan ke data kehadiran sistem.</p>
</div>

@if(session('error'))
    <div class="mb-6 rounded-lg bg-red-50 border border-red-200 text-red-700 text-sm px-4 py-3">{{ session('error') }}</div>
@endif

<div class="grid lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2">
        <x-card title="Unggah File">
            <form method="POST" action="{{ route('admin.attendance-monitoring.import') }}" enctype="multipart/form-data" class="space-y-5">
                @csrf
                <x-select name="internship_period_id" label="Periode Magang" :options="$periods->pluck('name', 'id')" :selected="old('internship_period_id')" required />
                <div>
                    <label for="file" class="form-label">File Excel (.xlsx) <span class="text-red-500">*</span></label>
                    <input type="file" name="file" id="file" accept=".xlsx" class="form-input" required>
                    @error('file')
                        <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div class="flex justify-end">
                    <button type="submit" class="btn btn-primary">
                        <i data-lucide="upload" class="w-4 h-4"></i> Import Sekarang
                    </button>
                </div>
            </form>
        </x-card>
    </div>

    <div class="lg:col-span-1">
        <x-card title="Format File">
            <p class="text-sm text-slate-500 mb-3">File harus memiliki baris header dengan kolom berikut (urutan bebas):</p>
            <ul class="text-sm text-slate-600 space-y-1.5 list-disc list-inside mb-4">
                <li><strong>Nama Lengkap</strong> &mdash; dicocokkan dengan data mahasiswa pada periode yang dipilih.</li>
                <li><strong>Waktu Presensi</strong> &mdash; berisi "Datang" atau "Pulang".</li>
                <li><strong>Date Created</strong> atau <strong>Tanggal</strong> &mdash; tanggal &amp; jam presensi.</li>
            </ul>
            <p class="text-sm text-slate-500">Kolom lain seperti <strong>No</strong>, <strong>Jabatan</strong>, dan <strong>Tanda Tangan</strong> tidak perlu diambil dan akan diabaikan bila ada.</p>
            <p class="text-sm text-slate-500 mt-3">Jika mahasiswa sudah punya data kehadiran pada tanggal yang sama, data akan diperbarui (bukan dobel), memakai sumber data yang sama dengan fitur Kehadiran pada role Mentor.</p>
        </x-card>
    </div>
</div>
@endsection
