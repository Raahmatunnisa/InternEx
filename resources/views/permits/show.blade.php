@extends('layouts.app')
@section('title', 'Detail Pengajuan Izin')

@section('content')
<div class="mb-6">
    <a href="{{ route('permits.index') }}" class="text-sm text-slate-500 hover:text-slate-700 flex items-center gap-1 mb-2">
        <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali ke Pengajuan Izin
    </a>
    <div class="flex flex-wrap items-center justify-between gap-3">
        <h1 class="text-2xl font-bold text-slate-900">Detail Pengajuan Izin</h1>
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
                        <a href="{{ route('permits.attachment', $permit) }}" target="_blank" class="inline-flex items-center gap-1.5 text-indigo-600 hover:underline font-medium">
                            <i data-lucide="file-text" class="w-4 h-4"></i> Lihat Dokumen
                        </a>
                    </dd></div>
                @endif
            </dl>
        </x-card>

        @if($permit->status !== 'pending')
            <x-card title="Keputusan Mentor">
                <dl class="space-y-3 text-sm">
                    <div><dt class="text-slate-400 mb-1">Direview oleh</dt><dd class="text-slate-700 font-medium">{{ $permit->reviewer->name ?? '-' }}</dd></div>
                    @if($permit->review_note)
                        <div><dt class="text-slate-400 mb-1">Catatan</dt><dd class="text-slate-700 whitespace-pre-line">{{ $permit->review_note }}</dd></div>
                    @endif
                </dl>
            </x-card>
        @endif
    </div>

    <div class="lg:col-span-1">
        <x-card title="Status">
            @if($permit->status === 'pending')
                <p class="text-sm text-slate-500">Menunggu persetujuan mentor pembimbing Anda.</p>
            @elseif($permit->status === 'approved')
                <p class="text-sm text-emerald-600 font-medium flex items-center gap-1.5"><i data-lucide="check-circle-2" class="w-4 h-4"></i> Pengajuan disetujui.</p>
            @else
                <p class="text-sm text-red-600 font-medium flex items-center gap-1.5"><i data-lucide="circle-x" class="w-4 h-4"></i> Pengajuan ditolak.</p>
            @endif
        </x-card>
    </div>
</div>
@endsection
