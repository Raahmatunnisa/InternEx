@extends('layouts.app')
@section('title', 'Edit Mentor')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.mentor.index') }}" class="text-sm text-slate-500 hover:text-slate-700 flex items-center gap-1 mb-2">
        <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali ke Kelola Mentor
    </a>
    <h1 class="text-2xl font-bold text-slate-900">Edit Mentor</h1>
</div>

<form method="POST" action="{{ route('admin.mentor.update', $mentor) }}">
    @method('PUT')
    @include('admin.mentor._form')
</form>
@endsection
