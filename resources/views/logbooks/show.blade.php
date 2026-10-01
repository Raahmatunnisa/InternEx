@extends('layouts.app')
@section('title', 'Detail Aktivitas')

@section('content')
<div class="mb-6">
    <a href="{{ route('logbooks.index') }}" class="text-sm text-slate-500 hover:text-slate-700 flex items-center gap-1 mb-2">
        <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali ke Aktivitas Harian
    </a>
    <div class="flex flex-wrap items-center justify-between gap-3">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">{{ $logbook->activity }}</h1>
            <p class="text-slate-500 mt-1">{{ $logbook->date->translatedFormat('l, d F Y') }}</p>
        </div>
        <x-badge :status="$logbook->status" class="text-sm px-3 py-1.5">{{ ucfirst($logbook->status) }}</x-badge>
    </div>
</div>

<div class="grid lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2 space-y-6">
        <x-card title="Detail Aktivitas">
            <dl class="space-y-4 text-sm">
                <div>
                    <dt class="text-slate-400 mb-1">Jam Kerja</dt>
                    <dd class="text-slate-800 font-medium">{{ $logbook->start_time->format('H:i') }} - {{ $logbook->end_time->format('H:i') }}</dd>
                </div>
                <div>
                    <dt class="text-slate-400 mb-1">Deskripsi</dt>
                    <dd class="text-slate-700 whitespace-pre-line">{{ $logbook->description }}</dd>
                </div>
                @if($logbook->output)
                <div>
                    <dt class="text-slate-400 mb-1">Output / Hasil</dt>
                    <dd class="text-slate-700 whitespace-pre-line">{{ $logbook->output }}</dd>
                </div>
                @endif
                @if($logbook->obstacle)
                <div>
                    <dt class="text-slate-400 mb-1">Kendala</dt>
                    <dd class="text-slate-700 whitespace-pre-line">{{ $logbook->obstacle }}</dd>
                </div>
                @endif
            </dl>
        </x-card>

        @if($logbook->feedbacks->isNotEmpty())
            <x-card title="Feedback Mentor">
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

    <div class="lg:col-span-1 space-y-4">
        @can('update', $logbook)
            <x-card>
                <a href="{{ route('logbooks.edit', $logbook) }}" class="btn btn-secondary w-full mb-3">
                    <i data-lucide="pencil" class="w-4 h-4"></i> Edit Aktivitas
                </a>
                <button type="button" onclick="toggleModal('delete-modal')" class="btn btn-danger w-full">
                    <i data-lucide="trash-2" class="w-4 h-4"></i> Hapus Aktivitas
                </button>
            </x-card>
        @endcan
    </div>
</div>

@can('delete', $logbook)
<x-modal id="delete-modal" title="Hapus Aktivitas?">
    <p class="text-sm text-slate-500 mb-5">Tindakan ini tidak dapat dibatalkan. Aktivitas akan dihapus secara permanen.</p>
    <div class="flex gap-3">
        <button type="button" onclick="toggleModal('delete-modal')" class="btn btn-secondary flex-1">Batal</button>
        <form method="POST" action="{{ route('logbooks.destroy', $logbook) }}" class="flex-1">
            @csrf @method('DELETE')
            <button type="submit" class="btn btn-danger w-full">Ya, Hapus</button>
        </form>
    </div>
</x-modal>
@endcan
@endsection
