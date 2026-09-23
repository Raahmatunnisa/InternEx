@extends('layouts.app')
@section('title', 'Ajukan Izin')

@section('content')
<div class="mb-6">
    <a href="{{ route('permits.index') }}" class="text-sm text-slate-500 hover:text-slate-700 flex items-center gap-1 mb-2">
        <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali ke Pengajuan Izin
    </a>
    <h1 class="text-2xl font-bold text-slate-900">Ajukan Izin</h1>
    <p class="text-slate-500 mt-1">Pengajuan akan dikirim ke mentor pembimbing Anda untuk disetujui.</p>
</div>

<form method="POST" action="{{ route('permits.store') }}" enctype="multipart/form-data">
    @csrf
    <div class="grid lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">
            <x-card title="Detail Izin">
                <div class="space-y-5">
                    <x-select name="type" label="Jenis Izin" :options="['sakit' => 'Sakit', 'izin' => 'Izin']" :selected="old('type')" required />
                    <div class="grid sm:grid-cols-2 gap-4">
                        <x-input type="date" name="start_date" label="Tanggal Mulai" :value="old('start_date')" required max="{{ now()->format('Y-m-d') }}" />
                        <x-input type="date" name="end_date" label="Tanggal Selesai" :value="old('end_date')" required />
                    </div>
                    <x-textarea name="reason" label="Alasan / Keterangan" rows="4" required placeholder="Jelaskan alasan ketidakhadiran Anda">{{ old('reason') }}</x-textarea>
                </div>
            </x-card>

            <x-card title="Dokumen Pendukung">
                <label for="attachment" class="flex flex-col items-center justify-center gap-2 rounded-xl border-2 border-dashed border-slate-300 p-6 cursor-pointer hover:border-indigo-400 hover:bg-indigo-50/40 transition">
                    <i data-lucide="upload" class="w-6 h-6 text-slate-400"></i>
                    <span class="text-sm text-slate-500">Unggah surat sakit/keterangan dokter (PDF, JPG, PNG, DOC, DOCX &middot; maks 5MB)</span>
                    <input type="file" name="attachment" id="attachment" class="hidden" onchange="previewFileName(this, 'attachment-name')">
                </label>
                <p id="attachment-name" class="hidden mt-2 text-sm text-slate-700 font-medium"></p>
                <p class="mt-2 text-xs text-slate-400">Wajib diunggah untuk pengajuan izin sakit.</p>
                @error('attachment')<p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>@enderror
            </x-card>
        </div>

        <div class="lg:col-span-1">
            <x-card title="Kirim Pengajuan">
                <p class="text-sm text-slate-500 mb-4">Pastikan seluruh informasi sudah benar sebelum mengirim.</p>
                <div class="flex flex-col gap-3">
                    <x-button type="submit">
                        <i data-lucide="send" class="w-4 h-4"></i> Kirim Pengajuan
                    </x-button>
                    <a href="{{ route('permits.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </x-card>
        </div>
    </div>
</form>
@endsection
