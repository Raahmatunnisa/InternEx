@extends('layouts.app')
@section('title', 'Tambah Riwayat Absen')

@section('content')
<div class="mb-6">
    <a href="{{ route('attendance-monitoring.index') }}" class="text-sm text-slate-500 hover:text-slate-700 flex items-center gap-1 mb-2">
        <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali ke Monitoring Kehadiran
    </a>
    <h1 class="text-2xl font-bold text-slate-900">Tambah Riwayat Absen</h1>
    <p class="text-slate-500 mt-1">Gunakan ini untuk mengisi kehadiran mahasiswa binaan Anda yang bolong/belum tercatat.</p>
</div>

<div class="max-w-xl">
    <x-card title="Data Kehadiran">
        <form method="POST" action="{{ route('attendance-monitoring.store') }}" class="space-y-5">
            @csrf

            <x-select name="internship_id" label="Mahasiswa" :options="$students->mapWithKeys(fn($i) => [$i->id => $i->student->name ?? '-'])" :selected="old('internship_id')" required />

            <x-input type="date" name="date" label="Tanggal" :value="old('date')" max="{{ now()->toDateString() }}" required />

            <x-select name="status" label="Status Kehadiran"
                :options="['hadir' => 'Hadir', 'terlambat' => 'Terlambat', 'izin' => 'Izin', 'sakit' => 'Sakit', 'alpha' => 'Alpha']"
                :selected="old('status', 'hadir')" :placeholder="null" required />

            <div class="grid sm:grid-cols-2 gap-4">
                <x-input type="time" name="check_in_time" label="Jam Masuk" :value="old('check_in_time')" />
                <x-input type="time" name="check_out_time" label="Jam Pulang" :value="old('check_out_time')" />
            </div>
            <p class="text-xs text-slate-400 -mt-3">Kosongkan jam masuk/pulang jika tidak relevan (mis. untuk status Izin, Sakit, atau Alpha).</p>
            <p class="text-xs text-slate-400">Jika mahasiswa yang dipilih sudah punya data pada tanggal tersebut, data lama akan diperbarui, bukan dobel.</p>

            <div class="flex flex-col sm:flex-row-reverse gap-3">
                <button type="submit" class="btn btn-primary">
                    <i data-lucide="check" class="w-4 h-4"></i> Simpan Riwayat Absen
                </button>
                <a href="{{ route('attendance-monitoring.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </x-card>
</div>
@endsection
