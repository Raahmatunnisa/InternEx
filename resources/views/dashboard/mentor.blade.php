@extends('layouts.app')
@section('title', 'Dashboard Mentor')

@section('content')
@php
$hour = now()->hour;
$greeting = $hour < 11 ? 'Selamat pagi' : ($hour < 15 ? 'Selamat siang' : ($hour < 18 ? 'Selamat sore' : 'Selamat malam'));
$greetingIcon = $hour < 11 ? 'sunrise' : ($hour < 18 ? 'sun' : 'moon');
@endphp

<div class="card overflow-hidden mb-6">
    <div class="grid lg:grid-cols-3">
        <div class="lg:col-span-2 p-6 sm:p-8">
            <h1 class="text-2xl font-bold text-slate-900 flex items-center gap-2">
                <i data-lucide="{{ $greetingIcon }}" class="w-6 h-6 text-indigo-500"></i>
                {{ $greeting }}, {{ explode(' ', auth()->user()->name)[0] }}
            </h1>
            <p class="text-slate-500 mt-1">Pantau perkembangan seluruh mahasiswa binaan Anda.</p>

            <div class="grid grid-cols-2 gap-4 mt-6">
                <div>
                    <p class="text-sm text-slate-500">Mahasiswa Binaan</p>
                    <p class="text-xl font-bold text-slate-900 mt-0.5">{{ $stats['total_students'] }}</p>
                </div>
                <div>
                    <p class="text-sm text-slate-500">Magang Aktif</p>
                    <p class="text-xl font-bold text-slate-900 mt-0.5">{{ $stats['active_students'] }}</p>
                </div>
            </div>
        </div>
        <div class="hidden lg:block relative">
            <x-photo-hero
                context="dashboard.mentor.hero"
                alt="Suasana pembinaan mahasiswa magang"
                :priority="true"
                class="h-full rounded-none"
                fallbackIcon="user-check"
            />
        </div>
    </div>
</div>

<div class="grid grid-cols-2 lg:grid-cols-5 gap-4 mb-6">
    <x-stat-card label="Mahasiswa Binaan" :value="$stats['total_students']" icon="users" color="indigo" />
    <x-stat-card label="Magang Aktif" :value="$stats['active_students']" icon="briefcase" color="emerald" />
    <x-stat-card label="Logbook Perlu Ditinjau" :value="$stats['pending_logbooks']" icon="clipboard-check" color="amber" />
    <x-stat-card label="Laporan Perlu Ditinjau" :value="$stats['pending_reports']" icon="file-text" color="blue" />
    <x-stat-card label="Persetujuan Izin/Sakit" :value="$stats['pending_permits']" icon="calendar-off" color="red" />
</div>

<div class="grid lg:grid-cols-3 gap-6">
    <x-card title="Kehadiran Terbaru" class="lg:col-span-2">
        @if($recentAttendances->isEmpty())
            <p class="text-sm text-slate-500 text-center py-4">Belum ada data kehadiran.</p>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="text-left text-slate-400 text-xs uppercase border-b border-slate-100">
                            <th class="pb-2 font-medium">Mahasiswa</th>
                            <th class="pb-2 font-medium">Tanggal</th>
                            <th class="pb-2 font-medium">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($recentAttendances as $att)
                            <tr>
                                <td class="py-2.5 font-medium text-slate-800">{{ $att->internship->student->name }}</td>
                                <td class="py-2.5 text-slate-500">{{ $att->date->translatedFormat('d M Y') }}</td>
                                <td class="py-2.5"><x-badge :status="$att->status">{{ ucfirst($att->status) }}</x-badge></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </x-card>

    <x-card title="Periode Magang Aktif" class="lg:col-span-1">
        @if($activePeriods->isEmpty())
            <p class="text-sm text-slate-500 text-center py-4">Belum ada periode aktif.</p>
        @else
            <ul class="space-y-3">
                @foreach($activePeriods as $period)
                    <li class="flex items-center justify-between">
                        <div class="min-w-0">
                            <p class="text-sm font-medium text-slate-800 truncate">{{ $period->name }}</p>
                            <p class="text-xs text-slate-400">{{ $period->start_date->translatedFormat('d M Y') }} - {{ $period->end_date->translatedFormat('d M Y') }}</p>
                        </div>
                        <x-badge status="active">Active</x-badge>
                    </li>
                @endforeach
            </ul>
        @endif
    </x-card>
</div>

<div class="grid lg:grid-cols-2 gap-6 mt-6">
    <x-card title="Belum Absen Hari Ini">
        @if($notYetAttendedToday->isEmpty())
            <p class="text-sm text-slate-500 text-center py-4">Semua mahasiswa aktif sudah tercatat kehadirannya hari ini.</p>
        @else
            <ul class="space-y-3">
                @foreach($notYetAttendedToday as $internship)
                    <li class="flex items-center gap-3">
                        <x-avatar-initials :name="$internship->student->name" size="w-9 h-9" textSize="text-xs" />
                        <div class="min-w-0">
                            <p class="text-sm font-medium text-slate-800 truncate">{{ $internship->student->name }}</p>
                            <p class="text-xs text-slate-400 truncate">{{ $internship->program }}</p>
                        </div>
                    </li>
                @endforeach
            </ul>
        @endif
    </x-card>

    <x-card title="Kehadiran Terbaik">
        @if($bestAttendance->isEmpty())
            <p class="text-sm text-slate-500 text-center py-4">Belum ada data kehadiran untuk dinilai.</p>
        @else
            <ul class="space-y-3">
                @foreach($bestAttendance as $internship)
                    <li class="flex items-center justify-between gap-3">
                        <div class="flex items-center gap-3 min-w-0">
                            <x-avatar-initials :name="$internship->student->name" size="w-9 h-9" textSize="text-xs" />
                            <p class="text-sm font-medium text-slate-800 truncate">{{ $internship->student->name }}</p>
                        </div>
                        <span class="text-sm font-semibold text-emerald-600 shrink-0">{{ $internship->attendance_rate }}%</span>
                    </li>
                @endforeach
            </ul>
        @endif
    </x-card>
</div>
@endsection
