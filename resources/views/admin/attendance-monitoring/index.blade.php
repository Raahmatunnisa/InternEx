@extends('layouts.app')
@section('title', 'Monitoring Kehadiran')

@section('content')
<div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
    <div>
        <h1 class="text-2xl font-bold text-slate-900">Monitoring Kehadiran</h1>
        <p class="text-slate-500 mt-1">Pantau rekap kehadiran seluruh mahasiswa magang.</p>
    </div>
    <div class="flex flex-wrap gap-2">
        <a href="{{ route('admin.attendance-monitoring.import-form') }}" class="btn btn-secondary">
            <i data-lucide="upload" class="w-4 h-4"></i> Import Excel
        </a>
        <a href="{{ route('admin.attendance-monitoring.export', request()->query()) }}" class="btn btn-primary">
            <i data-lucide="download" class="w-4 h-4"></i> Cetak Excel
        </a>
    </div>
</div>

@if(session('success'))
    <div class="mb-6 rounded-lg bg-emerald-50 border border-emerald-200 text-emerald-700 text-sm px-4 py-3">{{ session('success') }}</div>
@endif
@if(session('warning'))
    <div class="mb-6 rounded-lg bg-amber-50 border border-amber-200 text-amber-700 text-sm px-4 py-3">{{ session('warning') }}</div>
@endif
@if(session('error'))
    <div class="mb-6 rounded-lg bg-red-50 border border-red-200 text-red-700 text-sm px-4 py-3">{{ session('error') }}</div>
@endif

<div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-6">
    <x-stat-card label="Hadir" :value="$summary['hadir']" icon="check-circle-2" color="emerald" />
    <x-stat-card label="Izin" :value="$summary['izin']" icon="calendar-check" color="blue" />
    <x-stat-card label="Sakit" :value="$summary['sakit']" icon="circle-alert" color="indigo" />
    <x-stat-card label="Alpha" :value="$summary['alpha']" icon="circle-x" color="red" />
</div>

<x-card title="Rekap Kehadiran per Mahasiswa">
    <form method="GET" class="grid sm:grid-cols-5 gap-4 mb-5">
        <x-select name="internship_period_id" label="Periode Magang" :options="$periods->pluck('name', 'id')" :selected="request('internship_period_id')" placeholder="Semua Periode" />
        <x-select name="internship_id" label="Mahasiswa" :options="$students->mapWithKeys(fn($i) => [$i->id => $i->student->name ?? '-'])" :selected="request('internship_id')" placeholder="Semua Mahasiswa" />
        <x-input name="date_from" label="Dari Tanggal" type="date" :value="request('date_from')" />
        <x-input name="date_to" label="Sampai Tanggal" type="date" :value="request('date_to')" />
        <div class="flex items-end gap-2">
            <button type="submit" class="btn btn-primary w-full"><i data-lucide="filter" class="w-4 h-4"></i> Filter</button>
            @if(request()->anyFilled(['internship_period_id', 'internship_id', 'date_from', 'date_to']))
                <a href="{{ route('admin.attendance-monitoring.index') }}" class="btn btn-secondary" title="Reset filter"><i data-lucide="x" class="w-4 h-4"></i></a>
            @endif
        </div>
    </form>

    @if($internships->isEmpty())
        <x-empty-state title="Belum ada data mahasiswa magang" icon="calendar-x" />
    @else
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-slate-50 border-b border-slate-200">
                    <tr class="text-left text-slate-500 text-xs uppercase">
                        <th class="px-4 py-3 font-medium">Mahasiswa</th>
                        <th class="px-4 py-3 font-medium">Periode</th>
                        <th class="px-4 py-3 font-medium text-center">Hadir</th>
                        <th class="px-4 py-3 font-medium text-center">Izin</th>
                        <th class="px-4 py-3 font-medium text-center">Sakit</th>
                        <th class="px-4 py-3 font-medium text-center">Alpha</th>
                        <th class="px-4 py-3 font-medium text-center">% Kehadiran</th>
                        <th class="px-4 py-3 font-medium text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($internships as $internship)
                        @php $row = $recap[$internship->id]; @endphp
                        <tr class="hover:bg-slate-50">
                            <td class="px-4 py-3 font-medium text-slate-800">{{ $internship->student->name ?? '-' }}</td>
                            <td class="px-4 py-3 text-slate-500">{{ $internship->period->name ?? '-' }}</td>
                            <td class="px-4 py-3 text-center text-emerald-600 font-semibold">{{ $row['hadir'] }}</td>
                            <td class="px-4 py-3 text-center text-blue-600 font-semibold">{{ $row['izin'] }}</td>
                            <td class="px-4 py-3 text-center text-indigo-600 font-semibold">{{ $row['sakit'] }}</td>
                            <td class="px-4 py-3 text-center text-red-600 font-semibold">{{ $row['alpha'] }}</td>
                            <td class="px-4 py-3 text-center font-semibold text-slate-700">{{ $row['percentage'] }}%</td>
                            <td class="px-4 py-3 text-right">
                                <a href="{{ route('admin.attendance-monitoring.detail', $internship) }}" class="text-indigo-600 hover:underline font-medium">Detail</a>
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
