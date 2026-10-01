@extends('layouts.app')
@section('title', 'Review Laporan Akhir')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-slate-900">Review Laporan Akhir</h1>
    <p class="text-slate-500 mt-1">Tinjau laporan akhir yang telah dikirim mahasiswa binaan Anda.</p>
</div>

@if($finalReports->isEmpty())
    <x-empty-state title="Belum ada laporan untuk direview" description="Laporan akan muncul di sini setelah mahasiswa mengirimkan laporan akhir mereka." icon="file-text" />
@else
    <x-card class="!p-0 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-slate-50 border-b border-slate-200">
                    <tr class="text-left text-slate-500 text-xs uppercase">
                        <th class="px-5 py-3 font-medium">Mahasiswa</th>
                        <th class="px-5 py-3 font-medium">Judul Laporan</th>
                        <th class="px-5 py-3 font-medium">Status</th>
                        <th class="px-5 py-3 font-medium text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($finalReports as $report)
                        <tr class="hover:bg-slate-50">
                            <td class="px-5 py-3.5 font-medium text-slate-800">{{ $report->internship->student->name }}</td>
                            <td class="px-5 py-3.5 text-slate-700">{{ $report->title ?? '-' }}</td>
                            <td class="px-5 py-3.5"><x-badge :status="$report->status">{{ ucfirst($report->status) }}</x-badge></td>
                            <td class="px-5 py-3.5 text-right"><a href="{{ route('final-reports.show', $report) }}" class="text-indigo-600 hover:underline font-medium">Review</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </x-card>
    <div class="mt-6">{{ $finalReports->links() }}</div>
@endif
@endsection
