@extends('layouts.app')
@section('title', 'Review Aktivitas')

@section('content')
<div class="mb-6">
    <a href="{{ route('logbook-reviews.index') }}" class="text-sm text-slate-500 hover:text-slate-700 flex items-center gap-1 mb-2">
        <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali ke Review Aktivitas
    </a>
    <div class="flex flex-wrap items-center justify-between gap-3">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">{{ $logbook->activity }}</h1>
            <p class="text-slate-500 mt-1">{{ $logbook->internship->student->name }} &middot; {{ $logbook->date->translatedFormat('l, d F Y') }}</p>
        </div>
        <x-badge :status="$logbook->status" class="text-sm px-3 py-1.5">{{ ucfirst($logbook->status) }}</x-badge>
    </div>
</div>

<div class="grid lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2 space-y-6">
        <x-card title="Informasi Mahasiswa">
            <dl class="grid sm:grid-cols-2 gap-4 text-sm">
                <div><dt class="text-slate-400 mb-1">Nama</dt><dd class="font-medium text-slate-800">{{ $logbook->internship->student->name }}</dd></div>
                <div><dt class="text-slate-400 mb-1">Email</dt><dd class="font-medium text-slate-800">{{ $logbook->internship->student->email }}</dd></div>
                <div><dt class="text-slate-400 mb-1">Instansi</dt><dd class="font-medium text-slate-800">{{ $logbook->internship->institution }}</dd></div>
                <div><dt class="text-slate-400 mb-1">Program</dt><dd class="font-medium text-slate-800">{{ $logbook->internship->program }}</dd></div>
            </dl>
        </x-card>

        <x-card title="Detail Aktivitas">
            <dl class="space-y-4 text-sm">
                <div><dt class="text-slate-400 mb-1">Jam Kerja</dt><dd class="font-medium text-slate-800">{{ $logbook->start_time->format('H:i') }} - {{ $logbook->end_time->format('H:i') }}</dd></div>
                <div><dt class="text-slate-400 mb-1">Deskripsi</dt><dd class="text-slate-700 whitespace-pre-line">{{ $logbook->description }}</dd></div>
                @if($logbook->output)<div><dt class="text-slate-400 mb-1">Output</dt><dd class="text-slate-700 whitespace-pre-line">{{ $logbook->output }}</dd></div>@endif
                @if($logbook->obstacle)<div><dt class="text-slate-400 mb-1">Kendala</dt><dd class="text-slate-700 whitespace-pre-line">{{ $logbook->obstacle }}</dd></div>@endif
            </dl>
        </x-card>

        @if($logbook->feedbacks->isNotEmpty())
            <x-card title="Riwayat Feedback">
                <div class="space-y-4">
                    @foreach($logbook->feedbacks as $feedback)
                        <div class="rounded-xl bg-slate-50 border border-slate-200 p-4">
                            <div class="flex items-center justify-between mb-1.5">
                                <p class="text-sm font-semibold text-slate-800">{{ $feedback->mentor->name }}</p>
                                <p class="text-xs text-slate-400">{{ $feedback->created_at->translatedFormat('d M Y, H:i') }}</p>
                            </div>
                            <p class="text-sm text-slate-600">{{ $feedback->feedback }}</p>
                        </div>
                    @endforeach
                </div>
            </x-card>
        @endif
    </div>

    @if($logbook->status === 'submitted')
    <div class="lg:col-span-1">
        <x-card title="Tindakan Review">
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

<x-modal id="approve-modal" title="Setujui Aktivitas">
    <form method="POST" action="{{ route('logbook-reviews.approve', $logbook) }}">
        @csrf
        <x-textarea name="feedback" label="Catatan (opsional)" rows="3" placeholder="Berikan apresiasi atau catatan tambahan" />
        <div class="flex gap-3 mt-5">
            <button type="button" onclick="toggleModal('approve-modal')" class="btn btn-secondary flex-1">Batal</button>
            <button type="submit" class="btn btn-success flex-1">Ya, Approve</button>
        </div>
    </form>
</x-modal>

<x-modal id="reject-modal" title="Tolak Aktivitas">
    <form method="POST" action="{{ route('logbook-reviews.reject', $logbook) }}">
        @csrf
        <x-textarea name="feedback" label="Feedback (wajib diisi)" rows="3" required placeholder="Jelaskan alasan penolakan agar mahasiswa dapat memperbaiki" />
        <div class="flex gap-3 mt-5">
            <button type="button" onclick="toggleModal('reject-modal')" class="btn btn-secondary flex-1">Batal</button>
            <button type="submit" class="btn btn-danger flex-1">Ya, Reject</button>
        </div>
    </form>
</x-modal>
@endsection
