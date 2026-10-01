@extends('layouts.app')
@section('title', 'Monitoring Absensi')

@section('content')
<div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
    <div>
        <h1 class="text-2xl font-bold text-slate-900">Monitoring Kehadiran</h1>
        <p class="text-slate-500 mt-1">Pantau rekap kehadiran seluruh mahasiswa binaan Anda.</p>
    </div>
    <a href="{{ route('attendance-monitoring.create') }}" class="btn btn-primary">
        <i data-lucide="plus" class="w-4 h-4"></i> Tambah Riwayat Absen
    </a>
</div>

<x-photo-banner
    context="attendance-monitoring.banner"
    alt="Suasana kerja mahasiswa magang"
    heightClass="h-24 sm:h-28"
/>

@if(session('success'))
    <div class="mb-6 rounded-lg bg-emerald-50 border border-emerald-200 text-emerald-700 text-sm px-4 py-3">{{ session('success') }}</div>
@endif

<div class="grid grid-cols-2 sm:grid-cols-5 gap-4 mb-6">
    <x-stat-card label="Hadir" :value="$summary['hadir']" icon="check-circle-2" color="emerald" />
    <x-stat-card label="Terlambat" :value="$summary['terlambat']" icon="circle-alert" color="amber" />
    <x-stat-card label="Izin" :value="$summary['izin']" icon="calendar-check" color="blue" />
    <x-stat-card label="Sakit" :value="$summary['sakit']" icon="calendar-check" color="indigo" />
    <x-stat-card label="Alpha" :value="$summary['alpha']" icon="calendar-check" color="red" />
</div>

<x-card title="Rekap Kehadiran">
    <form method="GET" class="grid sm:grid-cols-4 gap-4 mb-5">
        <x-select name="student_id" label="Mahasiswa" :options="$students->pluck('student.name', 'id')" :selected="request('student_id')" placeholder="Semua Mahasiswa" />
        <x-select name="status" label="Status" :options="['hadir'=>'Hadir','terlambat'=>'Terlambat','izin'=>'Izin','sakit'=>'Sakit','alpha'=>'Alpha']" :selected="request('status')" placeholder="Semua Status" />
        <x-input name="date_from" label="Dari Tanggal" type="date" :value="request('date_from')" />
        <div class="flex items-end">
            <button type="submit" class="btn btn-primary w-full"><i data-lucide="filter" class="w-4 h-4"></i> Filter</button>
        </div>
    </form>

    @if($attendances->isEmpty())
        <x-empty-state title="Belum ada data kehadiran" icon="calendar-x" />
    @else
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-slate-50 border-b border-slate-200">
                    <tr class="text-left text-slate-500 text-xs uppercase">
                        <th class="px-4 py-3 font-medium">Mahasiswa</th>
                        <th class="px-4 py-3 font-medium">Tanggal</th>
                        <th class="px-4 py-3 font-medium">Masuk</th>
                        <th class="px-4 py-3 font-medium">Pulang</th>
                        <th class="px-4 py-3 font-medium">Status</th>
                        <th class="px-4 py-3 font-medium text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($attendances as $attendance)
                        <tr>
                            <td class="px-4 py-3 font-medium text-slate-800">{{ $attendance->internship->student->name }}</td>
                            <td class="px-4 py-3 text-slate-500">{{ $attendance->date->translatedFormat('d M Y') }}</td>
                            <td class="px-4 py-3 text-slate-500">{{ $attendance->check_in_time?->format('H:i') ?? '-' }}</td>
                            <td class="px-4 py-3 text-slate-500">{{ $attendance->check_out_time?->format('H:i') ?? '-' }}</td>
                            <td class="px-4 py-3"><x-badge :status="$attendance->display_status">{{ $attendance->display_label }}</x-badge></td>
                            <td class="px-4 py-3 text-right">
                                <div class="flex items-center justify-end gap-3">
                                    <a href="{{ route('attendance-monitoring.edit', $attendance) }}" class="text-indigo-600 hover:underline font-medium">Edit</a>
                                    <form method="POST" action="{{ route('attendance-monitoring.destroy', $attendance) }}" onsubmit="return confirm('Hapus data kehadiran {{ $attendance->internship->student->name }} tanggal {{ $attendance->date->translatedFormat('d M Y') }}? Tindakan ini tidak dapat dibatalkan.');">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:underline font-medium">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-6">{{ $attendances->links() }}</div>
    @endif
</x-card>
@endsection
