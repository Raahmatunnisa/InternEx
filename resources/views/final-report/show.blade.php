@extends('layouts.app')
@section('title', 'Laporan Akhir')

@section('content')
@php
$steps = ['draft' => 'Draft', 'submitted' => 'Submitted', 'reviewed' => 'Reviewed', 'approved' => 'Approved'];
$stepKeys = array_keys($steps);
$currentIndex = $finalReport->status === 'revision' ? 1 : array_search($finalReport->status, $stepKeys);
$canEdit = auth()->user()->can('update', $finalReport);
@endphp

<div class="mb-6">
    <h1 class="text-2xl font-bold text-slate-900">Laporan Akhir</h1>
    <p class="text-slate-500 mt-1">Dokumentasikan perjalanan dan hasil magangmu.</p>
</div>

<x-photo-banner
    context="final-report.banner"
    title="Laporan akhir yang baik mencerminkan kualitas kerja"
    subtitle="Susun laporan secara ringkas, jelas, dan didukung data yang relevan."
    alt="Suasana penyusunan laporan magang"
    heightClass="h-28 sm:h-36"
/>

{{-- Stepper --}}
<x-card class="mb-6">
    <div class="flex items-center">
        @foreach($stepKeys as $i => $key)
            <div class="flex items-center {{ !$loop->last ? 'flex-1' : '' }}">
                <div class="flex flex-col items-center">
                    <div class="w-9 h-9 rounded-full flex items-center justify-center text-sm font-semibold
                        {{ $i <= $currentIndex ? 'bg-indigo-600 text-white' : 'bg-slate-100 text-slate-400' }}">
                        @if($i < $currentIndex) <i data-lucide="check" class="w-4 h-4"></i> @else {{ $i + 1 }} @endif
                    </div>
                    <span class="text-xs mt-1.5 {{ $i <= $currentIndex ? 'text-slate-800 font-medium' : 'text-slate-400' }}">{{ $steps[$key] }}</span>
                </div>
                @if(!$loop->last)
                    <div class="flex-1 h-0.5 mx-2 {{ $i < $currentIndex ? 'bg-indigo-600' : 'bg-slate-100' }}"></div>
                @endif
            </div>
        @endforeach
    </div>
    @if($finalReport->status === 'revision')
        <div class="mt-4">
            <x-alert type="warning">
                <i data-lucide="circle-alert" class="w-5 h-5 shrink-0"></i>
                <span>Mentor meminta Anda untuk merevisi laporan ini. Silakan perbarui dan kirim ulang.</span>
            </x-alert>
        </div>
    @elseif(!$canEdit)
        <div class="mt-4">
            <x-alert type="info">
                <i data-lucide="lock" class="w-5 h-5 shrink-0"></i>
                <span>
                    @if($finalReport->status === 'submitted')
                        Laporan sudah dikirim dan sedang menunggu review mentor. Anda tidak dapat mengedit sampai mentor memberi feedback.
                    @elseif($finalReport->status === 'reviewed')
                        Laporan sedang dalam proses review mentor. Anda tidak dapat mengedit sampai proses review selesai.
                    @elseif($finalReport->status === 'approved')
                        Laporan akhir Anda sudah disetujui mentor. Tidak ada lagi perubahan yang diperlukan.
                    @endif
                </span>
            </x-alert>
        </div>
    @endif
</x-card>

<div class="grid lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2">
        <x-card title="Informasi Laporan">
            @if($canEdit)
                <form method="POST" action="{{ route('final-report.update', $finalReport) }}" enctype="multipart/form-data" class="space-y-5">
                    @csrf @method('PUT')
                    <x-input name="title" label="Judul Laporan" :value="$finalReport->title" required placeholder="Judul laporan akhir magang" />
                    <x-textarea name="abstract" label="Abstract / Ringkasan" rows="6" required placeholder="Ringkasan singkat laporan akhir">{{ $finalReport->abstract }}</x-textarea>

                    <div>
                        <label for="file" class="flex flex-col items-center justify-center gap-2 rounded-xl border-2 border-dashed border-slate-300 p-6 cursor-pointer hover:border-indigo-400 hover:bg-indigo-50/40 transition">
                            <i data-lucide="upload" class="w-6 h-6 text-slate-400"></i>
                            <span class="text-sm text-slate-500">Unggah file laporan (PDF, DOC, DOCX &middot; maks 10MB)</span>
                            <input type="file" name="file" id="file" class="hidden" onchange="previewFileName(this, 'file-name')">
                        </label>
                        <p id="file-name" class="hidden mt-2 text-sm text-slate-700 font-medium"></p>
                        @if($finalReport->file_path)
                            <p class="mt-2 text-sm text-slate-500">File saat ini: <a href="{{ route('final-report.preview', $finalReport) }}" target="_blank" class="text-indigo-600 hover:underline">Lihat file</a></p>
                        @endif
                        @error('file')<p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <div class="flex flex-wrap gap-3 pt-2">
                        <button type="submit" class="btn btn-secondary">
                            <i data-lucide="save" class="w-4 h-4"></i> Simpan Draft
                        </button>
                    </div>
                </form>

                @can('submit', $finalReport)
                    <form method="POST" action="{{ route('final-report.submit', $finalReport) }}" class="mt-3">
                        @csrf
                        <button type="submit" class="btn btn-primary">
                            <i data-lucide="send" class="w-4 h-4"></i> Kirim Laporan untuk Direview
                        </button>
                    </form>
                @endcan
            @else
                <dl class="space-y-4 text-sm">
                    <div><dt class="text-slate-400 mb-1">Judul Laporan</dt><dd class="text-slate-700 font-medium">{{ $finalReport->title ?? '-' }}</dd></div>
                    <div><dt class="text-slate-400 mb-1">Abstract</dt><dd class="text-slate-700 whitespace-pre-line">{{ $finalReport->abstract ?? '-' }}</dd></div>
                    @if($finalReport->file_path)
                        <div><dt class="text-slate-400 mb-1">File Laporan</dt><dd>
                            <a href="{{ route('final-report.preview', $finalReport) }}" target="_blank" class="inline-flex items-center gap-1.5 text-indigo-600 hover:underline font-medium">
                                <i data-lucide="file-text" class="w-4 h-4"></i> Lihat Laporan
                            </a>
                        </dd></div>
                    @endif
                </dl>
            @endif
        </x-card>
    </div>

    <div class="lg:col-span-1">
        <x-card title="Feedback Mentor">
            @if($finalReport->feedbacks->isEmpty())
                <p class="text-sm text-slate-500 text-center py-4">Belum ada feedback.</p>
            @else
                <div class="space-y-4">
                    @foreach($finalReport->feedbacks as $feedback)
                        <div class="rounded-xl bg-slate-50 border border-slate-200 p-4">
                            <div class="flex items-center justify-between mb-1.5">
                                <p class="text-sm font-semibold text-slate-800">{{ $feedback->mentor->name }}</p>
                                <p class="text-xs text-slate-400">{{ $feedback->created_at->translatedFormat('d M Y') }}</p>
                            </div>
                            <p class="text-sm text-slate-600">{{ $feedback->feedback }}</p>
                        </div>
                    @endforeach
                </div>
            @endif
        </x-card>
    </div>
</div>
@endsection
