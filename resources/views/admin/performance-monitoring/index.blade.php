@extends('layouts.app')
@section('title', 'Monitoring Kinerja')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-slate-900">Monitoring Kinerja</h1>
    <p class="text-slate-500 mt-1">Pantau progress logbook harian & laporan akhir seluruh mahasiswa magang.</p>
</div>

<x-card title="Kinerja per Mahasiswa">
    <form method="GET" class="grid sm:grid-cols-4 gap-4 mb-5">
        <div class="sm:col-span-2">
            <x-input name="search" label="Cari Nama Mahasiswa" :value="request('search')" placeholder="Ketik nama mahasiswa..." />
        </div>
        <x-select name="internship_period_id" label="Periode Magang" :options="$periods->pluck('name', 'id')" :selected="request('internship_period_id')" placeholder="Semua Periode" />
        <div class="flex items-end gap-2">
            <button type="submit" class="btn btn-primary w-full"><i data-lucide="filter" class="w-4 h-4"></i> Filter</button>
            @if(request()->anyFilled(['search', 'internship_period_id']))
                <a href="{{ route('admin.performance-monitoring.index') }}" class="btn btn-secondary" title="Reset filter"><i data-lucide="x" class="w-4 h-4"></i></a>
            @endif
        </div>
    </form>

    @if($internships->isEmpty())
        <x-empty-state title="Belum ada data mahasiswa magang" icon="activity" />
    @else
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-slate-50 border-b border-slate-200">
                    <tr class="text-left text-slate-500 text-xs uppercase">
                        <th class="px-4 py-3 font-medium">Mahasiswa</th>
                        <th class="px-4 py-3 font-medium">Periode</th>
                        <th class="px-4 py-3 font-medium w-64">Progress</th>
                        <th class="px-4 py-3 font-medium text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($internships as $internship)
                        <tr class="hover:bg-slate-50">
                            <td class="px-4 py-3 font-medium text-slate-800">{{ $internship->student->name ?? '-' }}</td>
                            <td class="px-4 py-3 text-slate-500">{{ $internship->period->name ?? '-' }}</td>
                            <td class="px-4 py-3">
                                <div class="space-y-2.5">
                                    <x-progress-bar-labeled label="Log Harian" icon="clipboard-list" :value="$internship->logbookProgressPercentage()" />
                                    <x-progress-bar-labeled label="Laporan" icon="file-text" :value="$internship->reportProgressPercentage()" />
                                </div>
                            </td>
                            <td class="px-4 py-3 text-right">
                                <a href="{{ route('admin.performance-monitoring.detail', $internship) }}" class="text-indigo-600 hover:underline font-medium">Detail</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-6">{{ $internships->links() }}</div>
    @endif
</x-card>
@endsection
