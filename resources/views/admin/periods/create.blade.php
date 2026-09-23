@extends('layouts.app')
@section('title', 'Tambah Periode Magang')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.periods.index') }}" class="text-sm text-slate-500 hover:text-slate-700 flex items-center gap-1 mb-2">
        <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali ke Periode Magang
    </a>
    <h1 class="text-2xl font-bold text-slate-900">Tambah Periode Magang</h1>
</div>

<form method="POST" action="{{ route('admin.periods.store') }}">
    @include('admin.periods._form')
</form>
@endsection
