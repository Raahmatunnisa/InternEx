@extends('layouts.app')
@section('title', 'Pengajuan Izin')

@section('content')
<div class="mb-6 flex flex-wrap items-center justify-between gap-3">
    <div>
        <h1 class="text-2xl font-bold text-slate-900">Pengajuan Izin</h1>
        <p class="text-slate-500 mt-1">Riwayat pengajuan izin/sakit dan status persetujuannya.</p>
    </div>
    <a href="{{ route('permits.create') }}" class="btn btn-primary">
        <i data-lucide="plus" class="w-4 h-4"></i> Ajukan Izin
    </a>
</div>

@if($permits->isEmpty())
    <x-empty-state title="Belum ada pengajuan izin" description="Ajukan izin sakit atau izin lainnya melalui tombol di atas." icon="calendar-off">
        <x-slot:action>
            <a href="{{ route('permits.create') }}" class="btn btn-primary">Ajukan Izin</a>
        </x-slot:action>
    </x-empty-state>
@else
    <x-card class="!p-0 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-slate-50 border-b border-slate-200">
                    <tr class="text-left text-slate-500 text-xs uppercase">
                        <th class="px-5 py-3 font-medium">Jenis</th>
                        <th class="px-5 py-3 font-medium">Periode</th>
                        <th class="px-5 py-3 font-medium">Alasan</th>
                        <th class="px-5 py-3 font-medium">Status</th>
                        <th class="px-5 py-3 font-medium text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($permits as $permit)
                        <tr class="hover:bg-slate-50">
                            <td class="px-5 py-3.5"><x-badge :status="$permit->type">{{ ucfirst($permit->type) }}</x-badge></td>
                            <td class="px-5 py-3.5 text-slate-700">{{ $permit->start_date->translatedFormat('d M Y') }} - {{ $permit->end_date->translatedFormat('d M Y') }}</td>
                            <td class="px-5 py-3.5 text-slate-600 max-w-xs truncate">{{ $permit->reason }}</td>
                            <td class="px-5 py-3.5">
                                <x-badge :status="$permit->status === 'approved' ? 'approved' : ($permit->status === 'rejected' ? 'rejected' : 'submitted')">
                                    {{ ['pending' => 'Menunggu', 'approved' => 'Disetujui', 'rejected' => 'Ditolak'][$permit->status] }}
                                </x-badge>
                            </td>
                            <td class="px-5 py-3.5 text-right"><a href="{{ route('permits.show', $permit) }}" class="text-indigo-600 hover:underline font-medium">Detail</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </x-card>
    <div class="mt-6">{{ $permits->links() }}</div>
@endif
@endsection
