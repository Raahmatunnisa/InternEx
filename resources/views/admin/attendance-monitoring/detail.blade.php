@extends('layouts.app')
@section('title', 'Detail Kehadiran - ' . ($internship->student->name ?? 'Mahasiswa'))

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.attendance-monitoring.index') }}" class="text-sm text-slate-500 hover:text-slate-700 flex items-center gap-1 mb-2">
        <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali ke Monitoring Kehadiran
    </a>
    <h1 class="text-2xl font-bold text-slate-900">{{ $internship->student->name ?? '-' }}</h1>
    <p class="text-slate-500 mt-1">
        {{ $internship->period->name ?? '-' }}
        @if($internship->mentor) &middot; Mentor: {{ $internship->mentor->name }} @endif
    </p>
</div>

<div class="grid grid-cols-2 sm:grid-cols-5 gap-4 mb-6">
    <x-stat-card label="Hadir" :value="$summary['hadir']" icon="check-circle-2" color="emerald" />
    <x-stat-card label="Izin" :value="$summary['izin']" icon="calendar-check" color="blue" />
    <x-stat-card label="Sakit" :value="$summary['sakit']" icon="circle-alert" color="indigo" />
    <x-stat-card label="Alpha" :value="$summary['alpha']" icon="circle-x" color="red" />
    <x-stat-card label="% Kehadiran" :value="$summary['percentage'] . '%'" icon="percent" color="amber" />
</div>

<x-card title="Riwayat Kehadiran Harian">
    <form method="GET" class="grid sm:grid-cols-3 gap-4 mb-5">
        <x-input name="date_from" label="Dari Tanggal" type="date" :value="request('date_from')" />
        <x-input name="date_to" label="Sampai Tanggal" type="date" :value="request('date_to')" />
        <div class="flex items-end gap-2">
            <button type="submit" class="btn btn-primary w-full"><i data-lucide="filter" class="w-4 h-4"></i> Filter</button>
            @if(request()->anyFilled(['date_from', 'date_to']))
                <a href="{{ route('admin.attendance-monitoring.detail', $internship) }}" class="btn btn-secondary" title="Reset filter"><i data-lucide="x" class="w-4 h-4"></i></a>
            @endif
        </div>
    </form>

    @if($attendances->isEmpty())
        <x-empty-state title="Belum ada data kehadiran" icon="calendar-x" />
    @else
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-slate-50 border-b border-slate-200">
                    <tr class="text-left text-slate-500 text-xs uppercase">
                        <th class="px-4 py-3 font-medium">Tanggal</th>
                        <th class="px-4 py-3 font-medium">Masuk</th>
                        <th class="px-4 py-3 font-medium">Pulang</th>
                        <th class="px-4 py-3 font-medium">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($attendances as $attendance)
                        <tr>
                            <td class="px-4 py-3 text-slate-700 font-medium">{{ $attendance->date->translatedFormat('d M Y') }}</td>
                            <td class="px-4 py-3 text-slate-500">{{ $attendance->check_in_time?->format('H:i') ?? '-' }}</td>
                            <td class="px-4 py-3 text-slate-500">{{ $attendance->check_out_time?->format('H:i') ?? '-' }}</td>
                            <td class="px-4 py-3"><x-badge :status="$attendance->display_status">{{ $attendance->display_label }}</x-badge></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-6">{{ $attendances->links() }}</div>
    @endif
</x-card>
@endsection
