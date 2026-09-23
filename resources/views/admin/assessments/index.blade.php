@extends('layouts.app')
@section('title', 'Monitoring Penilaian')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-slate-900">Monitoring Penilaian</h1>
    <p class="text-slate-500 mt-1">Pantau seluruh data penilaian mahasiswa yang sudah diberikan mentor.</p>
</div>

@if($assessments->isEmpty())
    <x-empty-state title="Belum ada data penilaian" description="Data akan muncul di sini setelah mentor memberikan nilai kepada mahasiswa bimbingannya." icon="clipboard-x" />
@else
    <x-card class="!p-0 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-slate-50 border-b border-slate-200">
                    <tr class="text-left text-slate-500 text-xs uppercase">
                        <th class="px-5 py-3 font-medium">Mahasiswa</th>
                        <th class="px-5 py-3 font-medium">Mentor</th>
                        <th class="px-5 py-3 font-medium">Periode</th>
                        <th class="px-5 py-3 font-medium text-right">Absensi</th>
                        <th class="px-5 py-3 font-medium text-right">Logbook</th>
                        <th class="px-5 py-3 font-medium text-right">Lap. Akhir</th>
                        <th class="px-5 py-3 font-medium text-right">Presentasi</th>
                        <th class="px-5 py-3 font-medium text-right">Nilai Akhir</th>
                        <th class="px-5 py-3 font-medium">Grade</th>
                        <th class="px-5 py-3 font-medium text-right">Cetak Dokumen</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($assessments as $assessment)
                        <tr class="hover:bg-slate-50">
                            <td class="px-5 py-3.5">
                                <p class="font-medium text-slate-800">{{ $assessment->internship->student->name ?? '-' }}</p>
                                <p class="text-xs text-slate-400">{{ $assessment->internship->student->email ?? '-' }}</p>
                            </td>
                            <td class="px-5 py-3.5 text-slate-600">{{ $assessment->internship->mentor->name ?? '-' }}</td>
                            <td class="px-5 py-3.5 text-slate-600">{{ $assessment->internship->period->name ?? '-' }}</td>
                            <td class="px-5 py-3.5 text-right text-slate-600">{{ number_format((float) $assessment->attendance_score, 2) }}</td>
                            <td class="px-5 py-3.5 text-right text-slate-600">{{ number_format((float) $assessment->logbook_score, 2) }}</td>
                            <td class="px-5 py-3.5 text-right text-slate-600">{{ number_format((float) $assessment->final_report_score, 2) }}</td>
                            <td class="px-5 py-3.5 text-right text-slate-600">{{ number_format((float) $assessment->presentation_score, 2) }}</td>
                            <td class="px-5 py-3.5 text-right font-semibold text-slate-800">{{ number_format((float) $assessment->final_score, 2) }}</td>
                            <td class="px-5 py-3.5"><x-badge status="approved">{{ $assessment->grade }} &middot; {{ number_format((float) $assessment->grade_point, 1) }}</x-badge></td>
                            <td class="px-5 py-3.5 text-right">
                                <div class="flex items-center justify-end gap-3">
                                    <a href="{{ route('admin.assessments.document', $assessment) }}" target="_blank" class="text-indigo-600 hover:underline font-medium">Preview</a>
                                    <a href="{{ route('admin.assessments.document', $assessment) }}?unduh=1" target="_blank" class="text-emerald-600 hover:underline font-medium">Unduh</a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </x-card>
    <div class="mt-6">{{ $assessments->links() }}</div>
@endif
@endsection
