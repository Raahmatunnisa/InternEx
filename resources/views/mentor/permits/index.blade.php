@extends('layouts.app')
@section('title', 'Pengajuan Izin Mahasiswa')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-slate-900">Pengajuan Izin Mahasiswa</h1>
    <p class="text-slate-500 mt-1">Tinjau dan proses pengajuan izin dari mahasiswa binaan Anda.</p>
</div>

@if($permits->isEmpty())
    <x-empty-state title="Belum ada pengajuan izin" description="Pengajuan izin dari mahasiswa binaan akan muncul di sini." icon="calendar-off" />
@else
    <x-card class="!p-0 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-slate-50 border-b border-slate-200">
                    <tr class="text-left text-slate-500 text-xs uppercase">
                        <th class="px-5 py-3 font-medium">Mahasiswa</th>
                        <th class="px-5 py-3 font-medium">Jenis</th>
                        <th class="px-5 py-3 font-medium">Periode</th>
                        <th class="px-5 py-3 font-medium">Status</th>
                        <th class="px-5 py-3 font-medium text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($permits as $permit)
                        <tr class="hover:bg-slate-50">
                            <td class="px-5 py-3.5 font-medium text-slate-800">{{ $permit->internship->student->name }}</td>
                            <td class="px-5 py-3.5"><x-badge :status="$permit->type">{{ ucfirst($permit->type) }}</x-badge></td>
                            <td class="px-5 py-3.5 text-slate-700">{{ $permit->start_date->translatedFormat('d M Y') }} - {{ $permit->end_date->translatedFormat('d M Y') }}</td>
                            <td class="px-5 py-3.5">
                                <x-badge :status="$permit->status === 'approved' ? 'approved' : ($permit->status === 'rejected' ? 'rejected' : 'submitted')">
                                    {{ ['pending' => 'Menunggu', 'approved' => 'Disetujui', 'rejected' => 'Ditolak'][$permit->status] }}
                                </x-badge>
                            </td>
                            <td class="px-5 py-3.5 text-right"><a href="{{ route('permits-review.show', $permit) }}" class="text-indigo-600 hover:underline font-medium">Detail</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </x-card>
    <div class="mt-6">{{ $permits->links() }}</div>
@endif
@endsection
