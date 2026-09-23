@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')
@php
$hour = now()->hour;
$greeting = $hour < 11 ? 'Selamat pagi' : ($hour < 15 ? 'Selamat siang' : ($hour < 18 ? 'Selamat sore' : 'Selamat malam'));
$greetingIcon = $hour < 11 ? 'sunrise' : ($hour < 18 ? 'sun' : 'moon');
@endphp

@if(!$internship)
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-slate-900 flex items-center gap-2">
            <i data-lucide="{{ $greetingIcon }}" class="w-6 h-6 text-indigo-500"></i>
            {{ $greeting }}, {{ explode(' ', auth()->user()->name)[0] }}
        </h1>
        <p class="text-slate-500 mt-1">Kelola aktivitas magang dan pantau perkembanganmu di sini.</p>
    </div>
    <x-empty-state
        title="Belum ada data magang aktif"
        description="Anda belum terdaftar pada program magang manapun. Silakan hubungi mentor atau administrator untuk didaftarkan."
        icon="briefcase"
    />
@else
    {{-- Hero: greeting + info periode + foto --}}
    <div class="card overflow-hidden mb-6">
        <div class="grid lg:grid-cols-3">
            <div class="lg:col-span-2 p-6 sm:p-8">
                <h1 class="text-2xl font-bold text-slate-900 flex items-center gap-2">
                    <i data-lucide="{{ $greetingIcon }}" class="w-6 h-6 text-indigo-500"></i>
                    {{ $greeting }}, {{ explode(' ', auth()->user()->name)[0] }}
                </h1>
                <p class="text-slate-500 mt-1">Kelola aktivitas magang dan pantau perkembanganmu hari ini.</p>

                <div class="mt-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div>
                        <p class="text-sm text-slate-500">Instansi Magang</p>
                        <h2 class="text-lg font-bold text-slate-900">{{ $internship->institution }}</h2>
                        <p class="text-sm text-slate-500 mt-0.5">{{ $internship->program }}</p>
                    </div>
                    <div class="text-sm text-slate-600 space-y-1 sm:text-right">
                        <p><span class="text-slate-400">Mentor:</span> {{ $internship->mentor->name }}</p>
                        <p><span class="text-slate-400">Periode:</span> {{ $internship->start_date->translatedFormat('d M Y') }} - {{ $internship->end_date->translatedFormat('d M Y') }}</p>
                        <p><span class="text-slate-400">Divisi/Tim Kerja:</span> {{ $internship->division->name ?? '-' }}</p>
                    </div>
                </div>
                <div class="mt-5">
                    <div class="flex items-center justify-between text-sm mb-1.5">
                        <span class="text-slate-500">Progress periode magang</span>
                        <span class="font-semibold text-slate-900">{{ $internship->progressPercentage() }}%</span>
                    </div>
                    <x-progress-bar :value="$internship->progressPercentage()" color="indigo" />
                </div>
            </div>
            <div class="hidden lg:block relative">
                <x-photo-hero
                    context="dashboard.mahasiswa.hero"
                    alt="Suasana kegiatan magang mahasiswa"
                    :priority="true"
                    class="h-full rounded-none"
                    fallbackIcon="briefcase"
                />
            </div>
        </div>
    </div>

    {{-- Statistik --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <x-stat-card label="Total Aktivitas" :value="$stats['total_logbook']" icon="clipboard-list" color="indigo" />
        <x-stat-card label="Menunggu Review" :value="$stats['logbook_pending']" icon="clock" color="amber" />
        <x-stat-card label="Kehadiran" :value="$stats['total_attendance'].' hari'" icon="calendar-check" color="emerald" />
        <x-stat-card label="Laporan Akhir" :value="ucfirst($finalReport?->status ?? 'draft')" icon="file-text" color="blue" />
    </div>

    {{-- Statistik Kehadiran --}}
    <div class="grid grid-cols-2 sm:grid-cols-5 gap-4 mb-6">
        <x-stat-card label="Hadir" :value="$attendanceSummary['hadir']" icon="check-circle-2" color="emerald" />
        <x-stat-card label="Terlambat" :value="$attendanceSummary['terlambat']" icon="circle-alert" color="amber" />
        <x-stat-card label="Izin" :value="$attendanceSummary['izin']" icon="calendar-check" color="blue" />
        <x-stat-card label="Sakit" :value="$attendanceSummary['sakit']" icon="calendar-check" color="indigo" />
        <x-stat-card label="Persentase Kehadiran" :value="$attendancePercentage.'%'" icon="trending-up" color="red" />
    </div>

    @if($pendingPermits > 0)
        <div class="mb-6">
            <x-alert type="info">
                <i data-lucide="calendar-off" class="w-5 h-5 shrink-0"></i>
                <span>Anda memiliki {{ $pendingPermits }} pengajuan izin yang masih menunggu persetujuan mentor. <a href="{{ route('permits.index') }}" class="font-semibold underline">Lihat status</a></span>
            </x-alert>
        </div>
    @endif

    <div class="grid lg:grid-cols-3 gap-6">
        {{-- Aksi cepat --}}
        <x-card title="Aksi Cepat" class="lg:col-span-1">
            <div class="grid grid-cols-2 gap-3">
                <a href="{{ route('logbooks.create') }}" class="flex flex-col items-center gap-2 rounded-xl border border-slate-200 p-4 hover:border-indigo-300 hover:bg-indigo-50 transition">
                    <i data-lucide="plus" class="w-5 h-5 text-indigo-600"></i>
                    <span class="text-xs font-medium text-slate-700 text-center">Tambah Aktivitas</span>
                </a>
                <a href="{{ route('attendances.index') }}" class="flex flex-col items-center gap-2 rounded-xl border border-slate-200 p-4 hover:border-emerald-300 hover:bg-emerald-50 transition">
                    <i data-lucide="log-in" class="w-5 h-5 text-emerald-600"></i>
                    <span class="text-xs font-medium text-slate-700 text-center">Absen Masuk</span>
                </a>
                <a href="{{ route('attendances.index') }}" class="flex flex-col items-center gap-2 rounded-xl border border-slate-200 p-4 hover:border-amber-300 hover:bg-amber-50 transition">
                    <i data-lucide="log-out" class="w-5 h-5 text-amber-600"></i>
                    <span class="text-xs font-medium text-slate-700 text-center">Absen Pulang</span>
                </a>
                <a href="{{ route('final-report.show') }}" class="flex flex-col items-center gap-2 rounded-xl border border-slate-200 p-4 hover:border-blue-300 hover:bg-blue-50 transition">
                    <i data-lucide="file-text" class="w-5 h-5 text-blue-600"></i>
                    <span class="text-xs font-medium text-slate-700 text-center">Laporan Akhir</span>
                </a>
            </div>
        </x-card>

        {{-- Status hari ini --}}
        <x-card title="Status Hari Ini" class="lg:col-span-1">
            @if($todayAttendance)
                <div class="space-y-3 text-sm">
                    <div class="flex items-center justify-between">
                        <span class="text-slate-500">Jam Masuk</span>
                        <span class="font-medium text-slate-900">{{ $todayAttendance->check_in_time?->format('H:i') ?? '-' }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-slate-500">Jam Pulang</span>
                        <span class="font-medium text-slate-900">{{ $todayAttendance->check_out_time?->format('H:i') ?? 'Belum absen pulang' }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-slate-500">Status</span>
                        <x-badge :status="$todayAttendance->status">{{ ucfirst($todayAttendance->status) }}</x-badge>
                    </div>
                </div>
            @else
                <div class="text-center py-4">
                    <i data-lucide="calendar-x" class="w-8 h-8 text-slate-300 mx-auto mb-2"></i>
                    <p class="text-sm text-slate-500">Anda belum absen hari ini.</p>
                    <a href="{{ route('attendances.index') }}" class="inline-flex items-center gap-1 mt-3 text-sm font-semibold text-indigo-600 hover:text-indigo-700">
                        Absen sekarang <i data-lucide="arrow-right" class="w-4 h-4"></i>
                    </a>
                </div>
            @endif
        </x-card>

        {{-- Perkembangan Magang / Aktivitas Terbaru --}}
        <x-card title="Aktivitas Terbaru" class="lg:col-span-1">
            @if($recentLogbooks->isEmpty())
                <p class="text-sm text-slate-500 text-center py-4">Belum ada aktivitas.</p>
            @else
                <ul class="space-y-3">
                    @foreach($recentLogbooks as $log)
                        <li>
                            <a href="{{ route('logbooks.show', $log) }}" class="flex items-start justify-between gap-3 group">
                                <div class="min-w-0">
                                    <p class="text-sm font-medium text-slate-800 truncate group-hover:text-indigo-600">{{ $log->activity }}</p>
                                    <p class="text-xs text-slate-400">{{ $log->date->translatedFormat('d M Y') }}</p>
                                </div>
                                <x-badge :status="$log->status">{{ ucfirst($log->status) }}</x-badge>
                            </a>
                        </li>
                    @endforeach
                </ul>
            @endif
        </x-card>
    </div>
@endif
@endsection
