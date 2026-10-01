@extends('layouts.app')
@section('title', 'Edit Kehadiran')

@section('content')
<div class="mb-6">
    <a href="{{ route('attendance-monitoring.index') }}" class="text-sm text-slate-500 hover:text-slate-700 flex items-center gap-1 mb-2">
        <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali ke Monitoring Kehadiran
    </a>
    <h1 class="text-2xl font-bold text-slate-900">Edit Kehadiran</h1>
    <p class="text-slate-500 mt-1">
        {{ $attendance->internship->student->name ?? '-' }} &middot; {{ $attendance->date->translatedFormat('d M Y') }}
    </p>
</div>

<div class="max-w-xl">
    <x-card title="Ubah Status & Jam Kehadiran" subtitle="Gunakan ini untuk menandai izin/sakit/alpha, atau membetulkan jam masuk-pulang mahasiswa.">
        <form method="POST" action="{{ route('attendance-monitoring.update', $attendance) }}" class="space-y-5">
            @csrf
            @method('PUT')

            <x-select name="status" label="Status Kehadiran"
                :options="['hadir' => 'Hadir', 'terlambat' => 'Terlambat', 'izin' => 'Izin', 'sakit' => 'Sakit', 'alpha' => 'Alpha']"
                :selected="old('status', $attendance->status)" :placeholder="null" required />

            <div class="grid sm:grid-cols-2 gap-4">
                <x-input type="time" name="check_in_time" label="Jam Masuk" :value="old('check_in_time', $attendance->check_in_time?->format('H:i'))" />
                <x-input type="time" name="check_out_time" label="Jam Pulang" :value="old('check_out_time', $attendance->check_out_time?->format('H:i'))" />
            </div>
            <p class="text-xs text-slate-400 -mt-3">Kosongkan jam masuk/pulang jika tidak relevan (mis. untuk status Izin, Sakit, atau Alpha).</p>

            <div class="flex flex-col sm:flex-row-reverse gap-3">
                <button type="submit" class="btn btn-primary">
                    <i data-lucide="check" class="w-4 h-4"></i> Simpan Perubahan
                </button>
                <a href="{{ route('attendance-monitoring.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </x-card>

    <x-card title="Hapus Data Kehadiran" class="mt-6">
        <p class="text-sm text-slate-500 mb-4">Gunakan ini jika data kehadiran ini keliru, misalnya mahasiswa sempat absen padahal hari tersebut adalah hari libur.</p>
        <form method="POST" action="{{ route('attendance-monitoring.destroy', $attendance) }}" onsubmit="return confirm('Hapus data kehadiran ini? Tindakan ini tidak dapat dibatalkan.');">
            @csrf @method('DELETE')
            <button type="submit" class="btn !bg-red-50 !text-red-600 hover:!bg-red-100">
                <i data-lucide="trash-2" class="w-4 h-4"></i> Hapus Data Ini
            </button>
        </form>
    </x-card>
</div>
@endsection
