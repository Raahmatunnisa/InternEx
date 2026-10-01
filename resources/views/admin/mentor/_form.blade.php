@csrf
<div class="max-w-xl">
    <x-card title="Data Akun Mentor">
        <div class="space-y-5">
            <x-input name="name" label="Nama Lengkap" :value="$mentor->name ?? ''" required />
            <x-input type="email" name="email" label="Email" :value="$mentor->email ?? ''" required />
            <x-input name="phone" label="Nomor HP" :value="$mentor->phone ?? ''" placeholder="08xxxxxxxxxx" />
            <x-input type="password" name="password" label="Password" :required="!isset($mentor)" toggle
                placeholder="{{ isset($mentor) ? 'Kosongkan jika tidak diubah' : 'Minimal 8 karakter' }}" />
            <label class="flex items-center gap-2 text-sm text-slate-700">
                <input type="checkbox" name="is_active" value="1" class="rounded border-slate-300 text-indigo-600 focus:ring-indigo-500" {{ old('is_active', $mentor->is_active ?? true) ? 'checked' : '' }}>
                Akun aktif (dapat login)
            </label>
        </div>
    </x-card>

    <div class="flex gap-3 mt-6">
        <button type="submit" class="btn btn-primary">
            <i data-lucide="check" class="w-4 h-4"></i> Simpan
        </button>
        <a href="{{ route('admin.mentor.index') }}" class="btn btn-secondary">Batal</a>
    </div>
</div>
