@extends('layouts.app')
@section('title', 'Dashboard Admin')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-slate-900">Dashboard Admin</h1>
    <p class="text-slate-500 mt-1">Ringkasan pengelolaan sistem InternX.</p>
</div>

<div class="grid grid-cols-2 lg:grid-cols-3 gap-4 mb-6">
    <x-stat-card label="Mahasiswa" :value="$stats['total_mahasiswa']" icon="graduation-cap" color="indigo" />
    <x-stat-card label="Mentor" :value="$stats['total_mentor']" icon="user-check" color="emerald" />
    <x-stat-card label="Periode Aktif" :value="$stats['active_period']" icon="calendar-range" color="blue" />
</div>

<div class="grid grid-cols-2 lg:grid-cols-5 gap-4 mb-6">
    <x-stat-card label="Total Admin" :value="$stats['total_admin']" icon="shield-check" color="indigo" />
    <x-stat-card label="Total Data Magang" :value="$stats['total_internship']" icon="briefcase" color="blue" />
    <x-stat-card label="Magang Aktif" :value="$stats['active_internship']" icon="activity" color="emerald" />
    <x-stat-card label="Magang Non Aktif" :value="$stats['inactive_internship']" icon="circle-slash" color="red" />
    <x-stat-card label="Total Record Kehadiran" :value="$stats['total_attendance']" icon="calendar-check" color="amber" />
</div>

<x-card title="Kehadiran Hari Ini (Seluruh Sistem)" class="mb-6">
    <div class="grid grid-cols-2 sm:grid-cols-5 gap-4">
        <x-stat-card label="Hadir" :value="$attendanceToday['hadir']" icon="check-circle-2" color="emerald" />
        <x-stat-card label="Terlambat" :value="$attendanceToday['terlambat']" icon="circle-alert" color="amber" />
        <x-stat-card label="Izin" :value="$attendanceToday['izin']" icon="calendar-check" color="blue" />
        <x-stat-card label="Sakit" :value="$attendanceToday['sakit']" icon="calendar-check" color="indigo" />
        <x-stat-card label="Alpha" :value="$attendanceToday['alpha']" icon="circle-x" color="red" />
    </div>
</x-card>

<div class="grid lg:grid-cols-2 gap-6">
    <x-card title="Periode Magang Aktif">
        @if($activePeriods->isEmpty())
            <p class="text-sm text-slate-500 text-center py-6">Belum ada periode aktif.</p>
        @else
            <div class="space-y-3">
                @foreach($activePeriods as $period)
                    <div class="flex items-center justify-between rounded-xl bg-slate-50 border border-slate-200 p-3.5">
                        <div>
                            <p class="text-sm font-semibold text-slate-800">{{ $period->name }}</p>
                            <p class="text-xs text-slate-400">{{ $period->start_date->translatedFormat('d M Y') }} - {{ $period->end_date->translatedFormat('d M Y') }}</p>
                        </div>
                        <span class="text-sm font-medium text-slate-600">{{ $period->internships_count }} mhs</span>
                    </div>
                @endforeach
            </div>
        @endif
        <a href="{{ route('admin.periods.index') }}" class="btn btn-secondary w-full mt-4">Kelola Periode</a>
    </x-card>

    <x-card title="Mahasiswa Terbaru">
        @if($recentMahasiswa->isEmpty())
            <p class="text-sm text-slate-500 text-center py-6">Belum ada mahasiswa terdaftar.</p>
        @else
            <div class="space-y-3">
                @foreach($recentMahasiswa as $mhs)
                    <div class="flex items-center gap-3">
                        <x-avatar-initials :name="$mhs->name" size="w-9 h-9" textSize="text-xs" />
                        <div class="min-w-0">
                            <p class="text-sm font-medium text-slate-800 truncate">{{ $mhs->name }}</p>
                            <p class="text-xs text-slate-400 truncate">{{ $mhs->email }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
        <a href="{{ route('admin.mahasiswa.index') }}" class="btn btn-secondary w-full mt-4">Kelola Mahasiswa</a>
    </x-card>
</div>
@endsection
