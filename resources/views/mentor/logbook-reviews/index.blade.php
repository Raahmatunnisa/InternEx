@extends('layouts.app')
@section('title', 'Review Aktivitas')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-slate-900">Review Aktivitas</h1>
    <p class="text-slate-500 mt-1">Tinjau dan berikan feedback aktivitas mahasiswa binaan Anda.</p>
</div>

<x-photo-banner
    context="logbook-reviews.banner"
    alt="Suasana supervisi mahasiswa magang"
    heightClass="h-24 sm:h-28"
/>

<x-card class="mb-6">
    <form method="GET" class="grid sm:grid-cols-4 gap-4">
        <x-select name="status" label="Status" :options="['submitted' => 'Submitted', 'approved' => 'Approved', 'rejected' => 'Rejected']" :selected="request('status')" placeholder="Semua Status" />
        <x-input name="date_from" label="Dari Tanggal" type="date" :value="request('date_from')" />
        <x-input name="date_to" label="Sampai Tanggal" type="date" :value="request('date_to')" />
        <div class="flex items-end">
            <button type="submit" class="btn btn-primary w-full"><i data-lucide="filter" class="w-4 h-4"></i> Filter</button>
        </div>
    </form>
</x-card>

@if($logbooks->isEmpty())
    <x-empty-state title="Tidak ada logbook" description="Belum ada logbook yang sesuai dengan filter." icon="clipboard-check" />
@else
    <x-card class="!p-0 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-slate-50 border-b border-slate-200">
                    <tr class="text-left text-slate-500 text-xs uppercase">
                        <th class="px-5 py-3 font-medium">Mahasiswa</th>
                        <th class="px-5 py-3 font-medium">Tanggal</th>
                        <th class="px-5 py-3 font-medium">Aktivitas</th>
                        <th class="px-5 py-3 font-medium">Status</th>
                        <th class="px-5 py-3 font-medium text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($logbooks as $logbook)
                        <tr class="hover:bg-slate-50">
                            <td class="px-5 py-3.5 font-medium text-slate-800">{{ $logbook->internship->student->name }}</td>
                            <td class="px-5 py-3.5 text-slate-500">{{ $logbook->date->translatedFormat('d M Y') }}</td>
                            <td class="px-5 py-3.5 text-slate-700 max-w-xs truncate">{{ $logbook->activity }}</td>
                            <td class="px-5 py-3.5"><x-badge :status="$logbook->status">{{ ucfirst($logbook->status) }}</x-badge></td>
                            <td class="px-5 py-3.5 text-right"><a href="{{ route('logbook-reviews.show', $logbook) }}" class="text-indigo-600 hover:underline font-medium">Review</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </x-card>
    <div class="mt-6">{{ $logbooks->links() }}</div>
@endif
@endsection
