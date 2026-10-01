@extends('layouts.app')
@section('title', 'Peserta Magang')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-slate-900">Peserta Magang</h1>
    <p class="text-slate-500 mt-1">Daftar mahasiswa yang menjadi tanggung jawab Anda.</p>
</div>

<x-photo-banner
    context="students.banner"
    title="Kembangkan potensi mahasiswa binaan Anda"
    alt="Suasana kolaborasi tim magang"
    heightClass="h-28 sm:h-36"
/>

@if($internships->isEmpty())
    <x-empty-state title="Belum ada mahasiswa binaan" description="Mahasiswa akan muncul di sini setelah didaftarkan sebagai binaan Anda." icon="users" />
@else
    <div class="grid md:grid-cols-2 gap-5">
        @foreach($internships as $internship)
            <x-card>
                <div class="flex items-start justify-between mb-3">
                    <div class="flex items-center gap-3">
                        <x-avatar-initials :name="$internship->student->name" />
                        <div>
                            <h3 class="font-semibold text-slate-900">{{ $internship->student->name }}</h3>
                            <p class="text-sm text-slate-500">{{ $internship->student->email }}</p>
                        </div>
                    </div>
                    <x-badge :status="$internship->status">{{ ucfirst($internship->status) }}</x-badge>
                </div>
                <dl class="text-sm space-y-1.5 mb-4">
                    <div class="flex justify-between"><dt class="text-slate-400">Instansi</dt><dd class="text-slate-700 font-medium">{{ $internship->institution }}</dd></div>
                    <div class="flex justify-between"><dt class="text-slate-400">Program</dt><dd class="text-slate-700 font-medium">{{ $internship->program }}</dd></div>
                    <div class="flex justify-between"><dt class="text-slate-400">Periode</dt><dd class="text-slate-700 font-medium">{{ $internship->period->name }}</dd></div>
                    <div class="flex justify-between"><dt class="text-slate-400">Divisi/Tim Kerja</dt><dd class="text-slate-700 font-medium">{{ $internship->division->name ?? '-' }}</dd></div>
                    <div class="flex justify-between"><dt class="text-slate-400">Total Aktivitas</dt><dd class="text-slate-700 font-medium">{{ $internship->logbooks_count }}</dd></div>
                </dl>
                <div class="mb-4">
                    <div class="flex items-center justify-between text-xs mb-1">
                        <span class="text-slate-400">Progress magang</span>
                        <span class="font-semibold text-slate-700">{{ $internship->progressPercentage() }}%</span>
                    </div>
                    <x-progress-bar :value="$internship->progressPercentage()" color="emerald" />
                </div>
                <a href="{{ route('students.show', $internship) }}" class="btn btn-secondary w-full">
                    <i data-lucide="eye" class="w-4 h-4"></i> Lihat Detail
                </a>
            </x-card>
        @endforeach
    </div>
    <div class="mt-6">{{ $internships->links() }}</div>
@endif
@endsection
