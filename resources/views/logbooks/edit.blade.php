@extends('layouts.app')
@section('title', 'Edit Aktivitas')

@section('content')
<div class="mb-6">
    <a href="{{ route('logbooks.show', $logbook) }}" class="text-sm text-slate-500 hover:text-slate-700 flex items-center gap-1 mb-2">
        <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali ke Detail
    </a>
    <h1 class="text-2xl font-bold text-slate-900">Edit Aktivitas</h1>
    <p class="text-slate-500 mt-1">Perbarui informasi aktivitas magang Anda.</p>
</div>

@if($logbook->status === 'rejected')
    <div class="mb-6">
        <x-alert type="warning">
            <i data-lucide="circle-alert" class="w-5 h-5 shrink-0"></i>
            <span>Aktivitas ini ditolak oleh mentor. Perbaiki sesuai feedback lalu simpan untuk mengirim ulang.</span>
        </x-alert>
    </div>
@endif

<form method="POST" action="{{ route('logbooks.update', $logbook) }}">
    @method('PUT')
    @include('logbooks._form')
</form>
@endsection
