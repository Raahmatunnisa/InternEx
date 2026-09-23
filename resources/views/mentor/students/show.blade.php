@extends('layouts.app')
@section('title', $internship->student->name)

@section('content')
<div class="mb-6">
    <a href="{{ route('students.index') }}" class="text-sm text-slate-500 hover:text-slate-700 flex items-center gap-1 mb-2">
        <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali ke Peserta Magang
    </a>
    <div class="flex items-center gap-4">
        <x-avatar-initials :name="$internship->student->name" size="w-14 h-14" textSize="text-lg" />
        <div>
            <h1 class="text-2xl font-bold text-slate-900">{{ $internship->student->name }}</h1>
            <p class="text-slate-500 mt-1">{{ $internship->student->email }} &middot; {{ $internship->institution }}</p>
        </div>
    </div>
</div>

<x-card title="Informasi Magang" class="mb-6">
    <dl class="grid sm:grid-cols-2 gap-4 text-sm">
        <div><dt class="text-slate-400 mb-1">Program</dt><dd class="text-slate-700 font-medium">{{ $internship->program }}</dd></div>
        <div><dt class="text-slate-400 mb-1">Periode</dt><dd class="text-slate-700 font-medium">{{ $internship->period->name ?? '-' }}</dd></div>
        <div><dt class="text-slate-400 mb-1">Divisi/Tim Kerja</dt><dd class="text-slate-700 font-medium">{{ $internship->division->name ?? '-' }}</dd></div>
    </dl>
</x-card>

<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    <x-stat-card label="Total Aktivitas" :value="$internship->logbooks()->count()" icon="clipboard-list" color="indigo" />
    <x-stat-card label="Attendance Rate" :value="$attendanceRate.'%'" icon="calendar-check" color="emerald" />
    <x-stat-card label="Progress Magang" :value="$internship->progressPercentage().'%'" icon="trending-up" color="blue" />
    <x-stat-card label="Status Laporan" :value="ucfirst($internship->finalReport?->status ?? 'draft')" icon="file-text" color="amber" />
</div>

@php $assessment = $internship->assessment; @endphp
<x-card title="Penilaian Mahasiswa" subtitle="Absensi 10% + Logbook 20% + Laporan Akhir 50% + Presentasi 20%" class="mb-6">
    <div class="grid lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2">
            <form method="POST" action="{{ route('assessments.store', $internship) }}" class="grid sm:grid-cols-2 gap-4">
                @csrf
                <x-input type="number" step="0.01" min="0" max="100" name="attendance_score" label="Absensi (10%)" :value="$assessment?->attendance_score" required />
                <x-input type="number" step="0.01" min="0" max="100" name="logbook_score" label="Logbook (20%)" :value="$assessment?->logbook_score" required />
                <x-input type="number" step="0.01" min="0" max="100" name="final_report_score" label="Laporan Akhir (50%)" :value="$assessment?->final_report_score" required />
                <x-input type="number" step="0.01" min="0" max="100" name="presentation_score" label="Presentasi (20%)" :value="$assessment?->presentation_score" required />
                <div class="sm:col-span-2">
                    <button type="submit" class="btn btn-primary">
                        <i data-lucide="save" class="w-4 h-4"></i> {{ $assessment ? 'Perbarui Nilai' : 'Simpan Nilai' }}
                    </button>
                </div>
            </form>
        </div>
        <div class="lg:col-span-1">
            <div class="rounded-xl bg-slate-50 border border-slate-200 p-4 h-full flex flex-col items-center text-center">
                @if($assessment)
                    <p class="text-xs text-slate-400 mb-1">Nilai Akhir</p>
                    <p class="text-3xl font-bold text-slate-900">{{ number_format((float) $assessment->final_score, 2) }}</p>
                    <div class="flex items-center gap-2 mt-2">
                        <x-badge status="approved">{{ $assessment->grade }}</x-badge>
                        <span class="text-sm text-slate-500">IP {{ number_format((float) $assessment->grade_point, 1) }}</span>
                    </div>
                @else
                    <i data-lucide="clipboard-x" class="w-8 h-8 text-slate-300 mb-2"></i>
                    <p class="text-sm text-slate-500">Penilaian belum tersedia</p>
                @endif

                <div class="w-full mt-4 pt-4 border-t border-slate-200 text-left">
                    <p class="text-xs font-medium text-slate-500 uppercase tracking-wide mb-2">Rentang Nilai (Grade)</p>
                    <table class="w-full text-xs">
                        <tbody class="divide-y divide-slate-200">
                            <tr class="{{ $assessment?->grade === 'A' ? 'font-semibold text-indigo-600' : 'text-slate-600' }}"><td class="py-1">A</td><td class="py-1 text-right">87 &ndash; 100</td></tr>
                            <tr class="{{ $assessment?->grade === 'AB' ? 'font-semibold text-indigo-600' : 'text-slate-600' }}"><td class="py-1">AB</td><td class="py-1 text-right">78 &ndash; 86,99</td></tr>
                            <tr class="{{ $assessment?->grade === 'B' ? 'font-semibold text-indigo-600' : 'text-slate-600' }}"><td class="py-1">B</td><td class="py-1 text-right">69 &ndash; 77,99</td></tr>
                            <tr class="{{ $assessment?->grade === 'BC' ? 'font-semibold text-indigo-600' : 'text-slate-600' }}"><td class="py-1">BC</td><td class="py-1 text-right">60 &ndash; 68,99</td></tr>
                            <tr class="{{ $assessment?->grade === 'C' ? 'font-semibold text-indigo-600' : 'text-slate-600' }}"><td class="py-1">C</td><td class="py-1 text-right">51 &ndash; 59,99</td></tr>
                            <tr class="{{ $assessment?->grade === 'D' ? 'font-semibold text-indigo-600' : 'text-slate-600' }}"><td class="py-1">D</td><td class="py-1 text-right">41 &ndash; 50,99</td></tr>
                            <tr class="{{ $assessment?->grade === 'E' ? 'font-semibold text-indigo-600' : 'text-slate-600' }}"><td class="py-1">E</td><td class="py-1 text-right">0 &ndash; 40,99</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-card>

<x-card title="Aktivitas Terbaru">
    @if($logbooks->isEmpty())
        <p class="text-sm text-slate-500 text-center py-4">Belum ada logbook.</p>
    @else
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left text-slate-400 text-xs uppercase border-b border-slate-100">
                        <th class="pb-2 font-medium">Tanggal</th>
                        <th class="pb-2 font-medium">Aktivitas</th>
                        <th class="pb-2 font-medium">Status</th>
                        <th class="pb-2 font-medium text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($logbooks as $logbook)
                        <tr>
                            <td class="py-2.5 text-slate-600">{{ $logbook->date->translatedFormat('d M Y') }}</td>
                            <td class="py-2.5 text-slate-800 font-medium">{{ $logbook->activity }}</td>
                            <td class="py-2.5"><x-badge :status="$logbook->status">{{ ucfirst($logbook->status) }}</x-badge></td>
                            <td class="py-2.5 text-right"><a href="{{ route('logbook-reviews.show', $logbook) }}" class="text-indigo-600 hover:underline font-medium">Detail</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</x-card>
@endsection
