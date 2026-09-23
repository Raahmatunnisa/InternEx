@extends('layouts.app')
@section('title', 'Absensi Magang')

@section('content')
<div class="mb-6 flex flex-wrap items-center justify-between gap-3">
    <div>
        <h1 class="text-2xl font-bold text-slate-900">Kehadiran Hari Ini</h1>
        <p class="text-slate-500 mt-1">Kelola absen masuk, pulang, dan riwayat kehadiran Anda.</p>
    </div>
    <a href="{{ route('permits.create') }}" class="btn btn-secondary">
        <i data-lucide="calendar-off" class="w-4 h-4"></i> Ajukan Izin
    </a>
</div>

{{-- Kartu status hari ini + visual --}}
<div class="card overflow-hidden mb-6">
    <div class="grid lg:grid-cols-3">
        <div class="lg:col-span-2 p-6 sm:p-8">
            <p class="text-sm text-slate-500 mb-1">{{ now()->translatedFormat('l, d F Y') }}</p>
            @if($todayAttendance)
                <div class="flex flex-wrap items-center gap-4 mt-2">
                    @if($todayAttendance->check_in_time)
                        <div class="flex items-center gap-2 text-sm">
                            <i data-lucide="log-in" class="w-4 h-4 text-emerald-600"></i>
                            <span class="text-slate-600">Masuk: <span class="font-semibold text-slate-900">{{ $todayAttendance->check_in_time->format('H:i') }}</span></span>
                        </div>
                    @endif
                    @if($todayAttendance->check_out_time)
                        <div class="flex items-center gap-2 text-sm">
                            <i data-lucide="log-out" class="w-4 h-4 text-amber-600"></i>
                            <span class="text-slate-600">Pulang: <span class="font-semibold text-slate-900">{{ $todayAttendance->check_out_time->format('H:i') }}</span></span>
                        </div>
                    @endif
                    <x-badge :status="$todayAttendance->status">{{ ucfirst($todayAttendance->status) }}</x-badge>
                </div>
                @if(!$todayAttendance->check_in_time)
                    <p class="text-slate-400 text-sm mt-2">Hari ini tercatat sebagai <strong>{{ $todayAttendance->status }}</strong>, sehingga tidak ada jam masuk/pulang.</p>
                @endif
            @else
                <p class="text-slate-400 text-sm mt-1">Anda belum melakukan absen masuk hari ini.</p>
            @endif

            <div class="mt-5">
                @if(!$todayAttendance)
                    <form method="POST" action="{{ route('attendances.checkIn') }}">
                        @csrf
                        <button type="submit" class="btn btn-success">
                            <i data-lucide="log-in" class="w-4 h-4"></i> Absen Masuk
                        </button>
                    </form>
                @elseif(!$todayAttendance->check_in_time)
                    {{-- Record hari ini berstatus izin/sakit/alpha (tanpa jam masuk), tidak ada aksi absen. --}}
                @elseif(!$todayAttendance->check_out_time)
                    <form method="POST" action="{{ route('attendances.checkOut') }}">
                        @csrf
                        <button type="submit" class="btn btn-primary">
                            <i data-lucide="log-out" class="w-4 h-4"></i> Absen Pulang
                        </button>
                    </form>
                @else
                    <span class="text-sm text-emerald-600 font-medium flex items-center gap-1.5">
                        <i data-lucide="check-circle-2" class="w-4 h-4"></i> Absensi hari ini lengkap
                    </span>
                @endif
            </div>
        </div>
        <div class="hidden lg:block relative">
            <x-photo-hero
                context="attendance.hero"
                alt="Suasana kerja mahasiswa magang saat jam kerja"
                class="h-full rounded-none"
                fallbackIcon="calendar-check"
            />
        </div>
    </div>
</div>

{{-- Statistik --}}
<div class="grid grid-cols-2 sm:grid-cols-5 gap-4 mb-6">
    <x-stat-card label="Hadir" :value="$summary['hadir']" icon="check-circle-2" color="emerald" />
    <x-stat-card label="Terlambat" :value="$summary['terlambat']" icon="circle-alert" color="amber" />
    <x-stat-card label="Izin" :value="$summary['izin']" icon="calendar-check" color="blue" />
    <x-stat-card label="Sakit" :value="$summary['sakit']" icon="calendar-check" color="indigo" />
    <x-stat-card label="Alpha" :value="$summary['alpha']" icon="calendar-check" color="red" />
</div>

<x-card title="Riwayat Kehadiran">
    <form method="GET" class="flex flex-wrap items-end gap-3 mb-5">
        <div class="w-48">
            <x-input type="month" name="month" label="Filter Bulan" :value="request('month')" />
        </div>
        <button type="submit" class="btn btn-secondary">
            <i data-lucide="filter" class="w-4 h-4"></i> Filter
        </button>
    </form>

    @if($attendances->isEmpty())
        <x-empty-state title="Belum ada riwayat kehadiran" icon="calendar-x" />
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
                            <td class="px-4 py-3 text-slate-700">{{ $attendance->date->translatedFormat('d M Y') }}</td>
                            <td class="px-4 py-3 text-slate-500">{{ $attendance->check_in_time?->format('H:i') ?? '-' }}</td>
                            <td class="px-4 py-3 text-slate-500">{{ $attendance->check_out_time?->format('H:i') ?? '-' }}</td>
                            <td class="px-4 py-3"><x-badge :status="$attendance->status">{{ ucfirst($attendance->status) }}</x-badge></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-6">{{ $attendances->links() }}</div>
    @endif
</x-card>
@endsection
