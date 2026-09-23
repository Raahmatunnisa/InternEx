@extends('layouts.app')
@section('title', 'Tambah Aktivitas')

@section('content')
<div class="mb-6">
    <a href="{{ route('logbooks.index') }}" class="text-sm text-slate-500 hover:text-slate-700 flex items-center gap-1 mb-2">
        <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali ke Aktivitas Harian
    </a>
    <h1 class="text-2xl font-bold text-slate-900">Tambah Aktivitas</h1>
    <p class="text-slate-500 mt-1">Catat aktivitas magang Anda hari ini.</p>
</div>

<form method="POST" action="{{ route('logbooks.store') }}">
    @include('logbooks._form')
</form>
@endsection
