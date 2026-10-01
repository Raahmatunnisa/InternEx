@extends('layouts.app')
@section('title', 'Aktivitas Harian')

@section('content')
<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
    <div>
        <h1 class="text-2xl font-bold text-slate-900">Aktivitas Harian</h1>
        <p class="text-slate-500 mt-1">Dokumentasikan pekerjaan dan pengalamanmu selama magang.</p>
    </div>
    <a href="{{ route('logbooks.create') }}" class="btn btn-primary">
        <i data-lucide="plus" class="w-4 h-4"></i> Tambah Aktivitas
    </a>
</div>

@if($logbooks->isNotEmpty())
    <x-photo-banner
        context="logbook.banner"
        title="Setiap catatan adalah bukti kontribusimu"
        subtitle="Aktivitas yang terdokumentasi dengan baik memudahkan mentor memberikan penilaian yang adil."
        alt="Suasana kerja tim magang"
        heightClass="h-28 sm:h-32"
    />
@endif

<x-card class="mb-6">
    <form method="GET" class="grid sm:grid-cols-4 gap-4">
        <x-select name="status" label="Status" :options="['submitted' => 'Submitted', 'approved' => 'Approved', 'rejected' => 'Rejected']" :selected="request('status')" placeholder="Semua Status" />
        <x-input name="date_from" label="Dari Tanggal" type="date" :value="request('date_from')" />
        <x-input name="date_to" label="Sampai Tanggal" type="date" :value="request('date_to')" />
        <div class="flex items-end">
            <x-button type="submit" class="w-full">
                <i data-lucide="filter" class="w-4 h-4"></i> Filter
            </x-button>
        </div>
    </form>
</x-card>

@if($logbooks->isEmpty())
    <div class="card overflow-hidden">
        <div class="grid md:grid-cols-2 items-center">
            <div class="p-8">
                <div class="w-16 h-16 rounded-2xl bg-slate-100 flex items-center justify-center mb-4">
                    <i data-lucide="clipboard-list" class="w-8 h-8 text-slate-400"></i>
                </div>
                <h3 class="text-sm font-semibold text-slate-700">Belum ada aktivitas</h3>
                <p class="text-sm text-slate-500 mt-1 max-w-sm">Mulai dokumentasikan aktivitas magang harianmu dengan menambahkan catatan baru.</p>
                <a href="{{ route('logbooks.create') }}" class="btn btn-primary mt-4">
                    <i data-lucide="plus" class="w-4 h-4"></i> Tambah Aktivitas
                </a>
            </div>
            <div class="hidden md:block h-64">
                <x-photo-hero context="logbook.banner" alt="Suasana kerja tim magang" class="rounded-none h-full" :overlay="false" fallbackIcon="clipboard-list" />
            </div>
        </div>
    </div>
@else
    {{-- Desktop table --}}
    <x-card class="hidden md:block !p-0 overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 border-b border-slate-200">
                <tr class="text-left text-slate-500 text-xs uppercase">
                    <th class="px-5 py-3 font-medium">Tanggal</th>
                    <th class="px-5 py-3 font-medium">Jam</th>
                    <th class="px-5 py-3 font-medium">Aktivitas</th>
                    <th class="px-5 py-3 font-medium">Status</th>
                    <th class="px-5 py-3 font-medium text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @foreach($logbooks as $logbook)
                    <tr class="hover:bg-slate-50">
                        <td class="px-5 py-3.5 text-slate-700">{{ $logbook->date->translatedFormat('d M Y') }}</td>
                        <td class="px-5 py-3.5 text-slate-500">{{ $logbook->start_time->format('H:i') }} - {{ $logbook->end_time->format('H:i') }}</td>
                        <td class="px-5 py-3.5 text-slate-800 font-medium max-w-xs truncate">{{ $logbook->activity }}</td>
                        <td class="px-5 py-3.5"><x-badge :status="$logbook->status">{{ ucfirst($logbook->status) }}</x-badge></td>
                        <td class="px-5 py-3.5 text-right">
                            <a href="{{ route('logbooks.show', $logbook) }}" class="text-indigo-600 hover:text-indigo-800 font-medium text-sm">Detail</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </x-card>

    {{-- Mobile cards --}}
    <div class="md:hidden space-y-3">
        @foreach($logbooks as $logbook)
            <a href="{{ route('logbooks.show', $logbook) }}" class="card p-4 block">
                <div class="flex items-start justify-between mb-2">
                    <p class="text-sm font-semibold text-slate-900">{{ $logbook->date->translatedFormat('d M Y') }}</p>
                    <x-badge :status="$logbook->status">{{ ucfirst($logbook->status) }}</x-badge>
                </div>
                <p class="text-sm text-slate-700 mb-1">{{ $logbook->activity }}</p>
                <p class="text-xs text-slate-400">{{ $logbook->start_time->format('H:i') }} - {{ $logbook->end_time->format('H:i') }}</p>
            </a>
        @endforeach
    </div>

    <div class="mt-6">{{ $logbooks->links() }}</div>
@endif
@endsection
