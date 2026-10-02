@extends('layouts.app')
@section('title', 'Kinerja - ' . ($internship->student->name ?? 'Mahasiswa'))

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.performance-monitoring.index') }}" class="text-sm text-slate-500 hover:text-slate-700 flex items-center gap-1 mb-2">
        <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali ke Monitoring Kinerja
    </a>
    <h1 class="text-2xl font-bold text-slate-900">{{ $internship->student->name ?? '-' }}</h1>
    <p class="text-slate-500 mt-1">
        {{ $internship->period->name ?? '-' }}
        @if($internship->mentor) &middot; Mentor: {{ $internship->mentor->name }} @endif
    </p>
</div>

<div class="grid lg:grid-cols-2 gap-4 mb-6">
    <x-card>
        <x-progress-bar-labeled label="Progress Logbook Harian" icon="clipboard-list" :value="$internship->logbookProgressPercentage()" />
        <p class="text-xs text-slate-400 mt-3">
            {{ $logbookTotals['approved'] }} entri disetujui dari {{ $internship->workingDaysElapsed() }} hari kerja yang sudah berjalan sejak {{ $internship->start_date->translatedFormat('d M Y') }}.
        </p>
    </x-card>
    <x-card>
        <x-progress-bar-labeled label="Progress Laporan Akhir" icon="file-text" :value="$internship->reportProgressPercentage()" />
        <p class="text-xs text-slate-400 mt-3">
            Status laporan saat ini:
            <x-badge :status="$internship->finalReport?->status ?? 'draft'">{{ ucfirst($internship->finalReport?->status ?? 'Belum ada') }}</x-badge>
        </p>
    </x-card>
</div>

<x-card title="Laporan Akhir" class="mb-6">
    @if($internship->finalReport && $internship->finalReport->status === 'approved' && $internship->finalReport->file_path)
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <p class="font-medium text-slate-800">{{ $internship->finalReport->title ?: 'Laporan Akhir Magang' }}</p>
                <p class="text-sm text-slate-500 mt-0.5">Sudah disetujui mentor &middot; siap dilihat/diunduh.</p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('admin.performance-monitoring.report-preview', $internship) }}" target="_blank" class="btn btn-secondary">
                    <i data-lucide="eye" class="w-4 h-4"></i> Preview
                </a>
                <a href="{{ route('admin.performance-monitoring.report-download', $internship) }}" class="btn btn-primary">
                    <i data-lucide="download" class="w-4 h-4"></i> Unduh
                </a>
            </div>
        </div>
    @else
        <x-empty-state
            title="Laporan belum tersedia"
            description="Laporan akhir mahasiswa ini belum diunggah, atau sudah diunggah namun belum disetujui oleh mentor pembimbing."
            icon="file-x"
        />
    @endif
</x-card>

<x-card title="Logbook Harian (Disetujui Mentor)">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-5">
        <div class="flex gap-4 text-sm text-slate-500">
            <span><span class="font-semibold text-emerald-600">{{ $logbookTotals['approved'] }}</span> disetujui</span>
            <span><span class="font-semibold text-amber-600">{{ $logbookTotals['submitted'] }}</span> menunggu review</span>
            <span><span class="font-semibold text-red-600">{{ $logbookTotals['rejected'] }}</span> ditolak</span>
        </div>
        @if($logbookTotals['approved'] > 0)
            <div class="flex gap-2">
                <a href="{{ route('admin.performance-monitoring.logbook-document', $internship) }}" target="_blank" class="btn btn-secondary">
                    <i data-lucide="eye" class="w-4 h-4"></i> Preview Dokumen
                </a>
                <a href="{{ route('admin.performance-monitoring.logbook-document', $internship) }}?unduh=1" target="_blank" class="btn btn-primary">
                    <i data-lucide="download" class="w-4 h-4"></i> Cetak / Unduh
                </a>
            </div>
        @endif
    </div>

    @if($logbooks->isEmpty())
        <x-empty-state title="Belum ada logbook yang disetujui mentor" icon="clipboard-x" />
    @else
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-slate-50 border-b border-slate-200">
                    <tr class="text-left text-slate-500 text-xs uppercase">
                        <th class="px-4 py-3 font-medium">Tanggal</th>
                        <th class="px-4 py-3 font-medium">Jam</th>
                        <th class="px-4 py-3 font-medium">Aktivitas</th>
                        <th class="px-4 py-3 font-medium">Output</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($logbooks as $logbook)
                        <tr>
                            <td class="px-4 py-3 text-slate-700 font-medium whitespace-nowrap">{{ $logbook->date->translatedFormat('d M Y') }}</td>
                            <td class="px-4 py-3 text-slate-500 whitespace-nowrap">{{ $logbook->start_time->format('H:i') }}&ndash;{{ $logbook->end_time->format('H:i') }}</td>
                            <td class="px-4 py-3 text-slate-800">{{ $logbook->activity }}</td>
                            <td class="px-4 py-3 text-slate-500">{{ $logbook->output ? \Illuminate\Support\Str::limit($logbook->output, 60) : '-' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-6">{{ $logbooks->links() }}</div>
    @endif
</x-card>
@endsection
