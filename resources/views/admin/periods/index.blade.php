@extends('layouts.app')
@section('title', 'Periode Magang')

@section('content')
<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
    <div>
        <h1 class="text-2xl font-bold text-slate-900">Periode Magang</h1>
        <p class="text-slate-500 mt-1">Kelola periode program magang mahasiswa.</p>
    </div>
    <a href="{{ route('admin.periods.create') }}" class="btn btn-primary">
        <i data-lucide="plus" class="w-4 h-4"></i> Tambah Periode
    </a>
</div>

<x-photo-banner
    context="periods.banner"
    title="Setiap periode adalah babak baru perjalanan magang"
    alt="Ilustrasi perjalanan waktu program magang"
    heightClass="h-24 sm:h-28"
/>

@if($periods->isEmpty())
    <x-empty-state title="Belum ada periode magang" description="Buat periode magang baru untuk mulai mengelola mahasiswa." icon="calendar-range">
        <x-slot:action>
            <a href="{{ route('admin.periods.create') }}" class="btn btn-primary">Tambah Periode</a>
        </x-slot:action>
    </x-empty-state>
@else
    <div class="grid md:grid-cols-2 gap-5">
        @foreach($periods as $period)
            <x-card>
                <div class="flex items-start justify-between mb-2">
                    <h3 class="font-semibold text-slate-900">{{ $period->name }}</h3>
                    <x-badge :status="$period->status">{{ $period->status === 'active' ? 'Active' : 'Completed' }}</x-badge>
                </div>
                <p class="text-sm text-slate-500 mb-3">{{ $period->start_date->translatedFormat('d M Y') }} - {{ $period->end_date->translatedFormat('d M Y') }}</p>
                @if($period->description)
                    <p class="text-sm text-slate-600 mb-4 line-clamp-2">{{ $period->description }}</p>
                @endif
                <div class="flex items-center justify-between text-sm text-slate-400 mb-4">
                    <span>{{ $period->internships_count }} mahasiswa</span>
                </div>
                <div class="flex gap-2">
                    <a href="{{ route('admin.periods.edit', $period) }}" class="btn btn-secondary flex-1">
                        <i data-lucide="pencil" class="w-4 h-4"></i> Edit
                    </a>
                    @if($period->internships_count === 0)
                        <form method="POST" action="{{ route('admin.periods.destroy', $period) }}" onsubmit="return confirm('Hapus periode ini?')" class="flex-1">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-danger w-full">
                                <i data-lucide="trash-2" class="w-4 h-4"></i> Hapus
                            </button>
                        </form>
                    @endif
                </div>
            </x-card>
        @endforeach
    </div>
    <div class="mt-6">{{ $periods->links() }}</div>
@endif
@endsection
