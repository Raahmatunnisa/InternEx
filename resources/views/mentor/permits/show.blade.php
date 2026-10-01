@extends('layouts.app')
@section('title', 'Review Pengajuan Izin')

@section('content')
<div class="mb-6">
    <a href="{{ route('permits-review.index') }}" class="text-sm text-slate-500 hover:text-slate-700 flex items-center gap-1 mb-2">
        <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali ke Pengajuan Izin
    </a>
    <div class="flex flex-wrap items-center justify-between gap-3">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Pengajuan Izin</h1>
            <p class="text-slate-500 mt-1">{{ $permit->internship->student->name }}</p>
        </div>
        <x-badge :status="$permit->status === 'approved' ? 'approved' : ($permit->status === 'rejected' ? 'rejected' : 'submitted')" class="text-sm px-3 py-1.5">
            {{ ['pending' => 'Menunggu', 'approved' => 'Disetujui', 'rejected' => 'Ditolak'][$permit->status] }}
        </x-badge>
    </div>
</div>

<div class="grid lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2 space-y-6">
        <x-card title="Informasi Izin">
            <dl class="space-y-4 text-sm">
                <div><dt class="text-slate-400 mb-1">Jenis</dt><dd><x-badge :status="$permit->type">{{ ucfirst($permit->type) }}</x-badge></dd></div>
                <div><dt class="text-slate-400 mb-1">Periode</dt><dd class="text-slate-700 font-medium">{{ $permit->start_date->translatedFormat('d M Y') }} - {{ $permit->end_date->translatedFormat('d M Y') }}</dd></div>
                <div><dt class="text-slate-400 mb-1">Alasan</dt><dd class="text-slate-700 whitespace-pre-line">{{ $permit->reason }}</dd></div>
                @if($permit->attachment_path)
                    <div><dt class="text-slate-400 mb-1">Dokumen Pendukung</dt><dd>
                        <a href="{{ route('permits-review.attachment', $permit) }}" target="_blank" class="inline-flex items-center gap-1.5 text-indigo-600 hover:underline font-medium">
                            <i data-lucide="file-text" class="w-4 h-4"></i> Lihat Dokumen
                        </a>
                        <p class="text-xs text-slate-400 mt-1">Terbuka di tab baru sebagai preview, bukan diunduh otomatis.</p>
                    </dd></div>
                @else
                    <div><dt class="text-slate-400 mb-1">Dokumen Pendukung</dt><dd class="text-slate-400 italic">Tidak ada dokumen dilampirkan.</dd></div>
                @endif
            </dl>
        </x-card>

        @if($permit->status !== 'pending' && $permit->review_note)
            <x-card title="Catatan Review">
                <p class="text-sm text-slate-600 whitespace-pre-line">{{ $permit->review_note }}</p>
            </x-card>
        @endif
    </div>

    @if($permit->status === 'pending')
    <div class="lg:col-span-1">
        <x-card title="Tindakan">
            <div class="flex flex-col gap-3">
                <button type="button" onclick="toggleModal('approve-modal')" class="btn btn-success">
                    <i data-lucide="check-circle-2" class="w-4 h-4"></i> Approve
                </button>
                <button type="button" onclick="toggleModal('reject-modal')" class="btn btn-danger">
                    <i data-lucide="circle-x" class="w-4 h-4"></i> Reject
                </button>
            </div>
        </x-card>
    </div>
    @endif
</div>

<x-modal id="approve-modal" title="Approve Pengajuan Izin">
    <form method="POST" action="{{ route('permits-review.approve', $permit) }}">
        @csrf
        <x-textarea name="review_note" label="Catatan (opsional)" rows="3" />
        <div class="flex gap-3 mt-5">
            <button type="button" onclick="toggleModal('approve-modal')" class="btn btn-secondary flex-1">Batal</button>
            <button type="submit" class="btn btn-success flex-1">Ya, Approve</button>
        </div>
    </form>
</x-modal>

<x-modal id="reject-modal" title="Reject Pengajuan Izin">
    <form method="POST" action="{{ route('permits-review.reject', $permit) }}">
        @csrf
        <x-textarea name="review_note" label="Alasan Penolakan (wajib diisi)" rows="3" required placeholder="Jelaskan alasan penolakan" />
        <div class="flex gap-3 mt-5">
            <button type="button" onclick="toggleModal('reject-modal')" class="btn btn-secondary flex-1">Batal</button>
            <button type="submit" class="btn btn-danger flex-1">Ya, Reject</button>
        </div>
    </form>
</x-modal>
@endsection
