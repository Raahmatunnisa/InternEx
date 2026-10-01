@csrf
@php $internship = $mahasiswa->internship ?? null; @endphp
<div class="space-y-6">
    <x-card title="Data Akun">
        <div class="space-y-5">
            <x-input name="name" label="Nama Lengkap" :value="$mahasiswa->name ?? ''" required />
            <x-input type="email" name="email" label="Email" :value="$mahasiswa->email ?? ''" required />
            <x-input name="phone" label="Nomor HP" :value="$mahasiswa->phone ?? ''" placeholder="08xxxxxxxxxx" />
            <x-input type="password" name="password" label="Password" :required="!isset($mahasiswa)" toggle
                placeholder="{{ isset($mahasiswa) ? 'Kosongkan jika tidak diubah' : 'Minimal 8 karakter' }}" />
            <label class="flex items-center gap-2 text-sm text-slate-700">
                <input type="checkbox" name="is_active" value="1" class="rounded border-slate-300 text-indigo-600 focus:ring-indigo-500" {{ old('is_active', $mahasiswa->is_active ?? true) ? 'checked' : '' }}>
                Akun aktif (dapat login)
            </label>
        </div>
    </x-card>

    <x-card title="Penempatan Magang" subtitle="Opsional saat pembuatan akun. Dapat dilengkapi/diubah kapan saja.">
        <div class="space-y-5">
            <div class="grid sm:grid-cols-2 gap-4">
                <x-select name="mentor_id" label="Mentor Pembimbing" :options="$mentors->pluck('name', 'id')" :selected="$internship->mentor_id ?? null" />
                <x-select name="internship_period_id" label="Periode Magang" :options="$periods->pluck('name', 'id')" :selected="$internship->internship_period_id ?? null" />
            </div>
            <div class="grid gap-4">
                <x-select name="division_id" label="Bagian/Divisi" :options="$divisions->pluck('name', 'id')" :selected="$internship->division_id ?? null" />
            </div>
            <div class="grid sm:grid-cols-2 gap-4">
                <x-input name="institution" label="Instansi" :value="$internship->institution ?? ''" />
                <x-input name="program" label="Program" :value="$internship->program ?? ''" />
            </div>
            <div class="grid sm:grid-cols-2 gap-4">
                <x-input type="date" name="start_date" label="Tanggal Mulai" :value="isset($internship) ? $internship->start_date->format('Y-m-d') : ''" />
                <x-input type="date" name="end_date" label="Tanggal Selesai" :value="isset($internship) ? $internship->end_date->format('Y-m-d') : ''" />
            </div>
            @if(isset($mahasiswa))
                <x-select name="internship_status" label="Status Magang" :options="['active' => 'Active', 'completed' => 'Completed']" :selected="$internship->status ?? 'active'" :placeholder="null" />
            @endif
        </div>
    </x-card>

    <div class="flex flex-col sm:flex-row-reverse gap-3">
        <button type="submit" class="btn btn-primary">
            <i data-lucide="check" class="w-4 h-4"></i> Simpan
        </button>
        <a href="{{ route('admin.mahasiswa.index') }}" class="btn btn-secondary">Batal</a>
    </div>
</div>
