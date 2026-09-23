@extends('layouts.app')
@section('title', 'Tambah Mahasiswa')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.mahasiswa.index') }}" class="text-sm text-slate-500 hover:text-slate-700 flex items-center gap-1 mb-2">
        <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali ke Kelola Mahasiswa
    </a>
    <h1 class="text-2xl font-bold text-slate-900">Tambah Akun Mahasiswa</h1>
</div>

<form method="POST" action="{{ route('admin.mahasiswa.store') }}">
    @include('admin.mahasiswa._form')
</form>
@endsection
