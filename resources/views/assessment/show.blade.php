@extends('layouts.app')
@section('title', 'Nilai')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-slate-900">Nilai</h1>
    <p class="text-slate-500 mt-1">Hasil penilaian magang yang diberikan oleh mentor pembimbing.</p>
</div>

@if(! $assessment)
    <x-empty-state
        title="Penilaian belum tersedia"
        description="Mentor pembimbing Anda belum memberikan nilai. Silakan cek kembali secara berkala."
        icon="clipboard-x"
    />
@else
    <div class="grid lg:grid-cols-3 gap-6">
        <div class="lg:col-span-1">
            <x-card class="text-center">
                <p class="text-sm text-slate-400 mb-1">Nilai Akhir</p>
                <p class="text-4xl font-bold text-slate-900">{{ number_format((float) $assessment->final_score, 2) }}</p>
                <div class="flex items-center justify-center gap-2 mt-3">
                    <x-badge status="approved">Nilai Huruf: {{ $assessment->grade }}</x-badge>
                </div>
                <p class="text-sm text-slate-500 mt-2">Grade Point: <span class="font-semibold text-slate-700">{{ number_format((float) $assessment->grade_point, 1) }}</span></p>
            </x-card>
        </div>

        <div class="lg:col-span-2">
            <x-card title="Rincian Komponen Penilaian">
                <div class="space-y-4">
                    <div>
                        <div class="flex items-center justify-between text-sm mb-1.5">
                            <span class="text-slate-600">Absensi <span class="text-slate-400">(bobot {{ number_format($weights['attendance'], 0) }}%)</span></span>
                            <span class="font-semibold text-slate-800">{{ number_format((float) $assessment->attendance_score, 2) }}</span>
                        </div>
                        <x-progress-bar :value="(float) $assessment->attendance_score" color="indigo" />
                    </div>
                    <div>
                        <div class="flex items-center justify-between text-sm mb-1.5">
                            <span class="text-slate-600">Logbook <span class="text-slate-400">(bobot {{ number_format($weights['logbook'], 0) }}%)</span></span>
                            <span class="font-semibold text-slate-800">{{ number_format((float) $assessment->logbook_score, 2) }}</span>
                        </div>
                        <x-progress-bar :value="(float) $assessment->logbook_score" color="emerald" />
                    </div>
                    <div>
                        <div class="flex items-center justify-between text-sm mb-1.5">
                            <span class="text-slate-600">Laporan Akhir <span class="text-slate-400">(bobot {{ number_format($weights['final_report'], 0) }}%)</span></span>
                            <span class="font-semibold text-slate-800">{{ number_format((float) $assessment->final_report_score, 2) }}</span>
                        </div>
                        <x-progress-bar :value="(float) $assessment->final_report_score" color="blue" />
                    </div>
                    <div>
                        <div class="flex items-center justify-between text-sm mb-1.5">
                            <span class="text-slate-600">Presentasi <span class="text-slate-400">(bobot {{ number_format($weights['presentation'], 0) }}%)</span></span>
                            <span class="font-semibold text-slate-800">{{ number_format((float) $assessment->presentation_score, 2) }}</span>
                        </div>
                        <x-progress-bar :value="(float) $assessment->presentation_score" color="amber" />
                    </div>
                </div>
            </x-card>
        </div>
    </div>
@endif
@endsection
