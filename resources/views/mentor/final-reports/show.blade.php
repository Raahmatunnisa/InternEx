@extends('layouts.app')
@section('title', 'Review Laporan Akhir')

@section('content')
<div class="mb-6">
    <a href="{{ route('final-reports.index') }}" class="text-sm text-slate-500 hover:text-slate-700 flex items-center gap-1 mb-2">
        <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali ke Review Laporan
    </a>
    <div class="flex flex-wrap items-center justify-between gap-3">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">{{ $finalReport->title ?? 'Laporan Akhir' }}</h1>
            <p class="text-slate-500 mt-1">{{ $finalReport->internship->student->name }}</p>
        </div>
        <x-badge :status="$finalReport->status" class="text-sm px-3 py-1.5">{{ ucfirst($finalReport->status) }}</x-badge>
    </div>
</div>

<div class="grid lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2 space-y-6">
        <x-card title="Informasi Laporan">
            <dl class="space-y-4 text-sm">
                <div><dt class="text-slate-400 mb-1">Abstract</dt><dd class="text-slate-700 whitespace-pre-line">{{ $finalReport->abstract }}</dd></div>
                @if($finalReport->file_path)
                    <div><dt class="text-slate-400 mb-1">File Laporan</dt><dd>
                        <a href="{{ route('final-reports.preview', $finalReport) }}" target="_blank" class="inline-flex items-center gap-1.5 text-indigo-600 hover:underline font-medium">
                            <i data-lucide="file-text" class="w-4 h-4"></i> Lihat Laporan
                        </a>
                        <p class="text-xs text-slate-400 mt-1">Terbuka di tab baru. File PDF akan tampil langsung di browser; file DOC/DOCX akan diunduh oleh browser sesuai kemampuan bawaannya.</p>
                    </dd></div>
                @endif
            </dl>
        </x-card>

        @if($finalReport->feedbacks->isNotEmpty())
            <x-card title="Riwayat Feedback">
                <div class="space-y-4">
                    @foreach($finalReport->feedbacks as $feedback)
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

    @if(in_array($finalReport->status, ['submitted', 'reviewed']))
    <div class="lg:col-span-1">
        <x-card title="Tindakan Review">
            <div class="flex flex-col gap-3">
                <button type="button" onclick="toggleModal('review-modal')" class="btn btn-secondary">
                    <i data-lucide="eye" class="w-4 h-4"></i> Tandai Direview
                </button>
                <button type="button" onclick="toggleModal('approve-modal')" class="btn btn-success">
                    <i data-lucide="check-circle-2" class="w-4 h-4"></i> Approve
                </button>
                <button type="button" onclick="toggleModal('revision-modal')" class="btn btn-danger">
                    <i data-lucide="rotate-ccw" class="w-4 h-4"></i> Minta Revisi
                </button>
            </div>
        </x-card>
    </div>
    @endif
</div>

<x-modal id="review-modal" title="Tandai Sebagai Direview">
    <form method="POST" action="{{ route('final-reports.review', $finalReport) }}">
        @csrf
        <x-textarea name="feedback" label="Catatan (opsional)" rows="3" />
        <div class="flex gap-3 mt-5">
            <button type="button" onclick="toggleModal('review-modal')" class="btn btn-secondary flex-1">Batal</button>
            <button type="submit" class="btn btn-secondary flex-1">Simpan</button>
        </div>
    </form>
</x-modal>

<x-modal id="approve-modal" title="Approve Laporan Akhir">
    <form method="POST" action="{{ route('final-reports.approve', $finalReport) }}">
        @csrf
        <x-textarea name="feedback" label="Catatan (opsional)" rows="3" />
        <div class="flex gap-3 mt-5">
            <button type="button" onclick="toggleModal('approve-modal')" class="btn btn-secondary flex-1">Batal</button>
            <button type="submit" class="btn btn-success flex-1">Ya, Approve</button>
        </div>
    </form>
</x-modal>

<x-modal id="revision-modal" title="Minta Revisi Laporan">
    <form method="POST" action="{{ route('final-reports.request-revision', $finalReport) }}">
        @csrf
        <x-textarea name="feedback" label="Feedback (wajib diisi)" rows="3" required placeholder="Jelaskan bagian yang perlu direvisi" />
        <div class="flex gap-3 mt-5">
            <button type="button" onclick="toggleModal('revision-modal')" class="btn btn-secondary flex-1">Batal</button>
            <button type="submit" class="btn btn-danger flex-1">Ya, Minta Revisi</button>
        </div>
    </form>
</x-modal>
@endsection
