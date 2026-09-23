@csrf
<x-card title="Informasi Periode">
    <div class="space-y-5">
        <x-input name="name" label="Nama Periode" :value="$period->name ?? ''" required placeholder="Contoh: Magang Genap 2026" />
        <div class="grid sm:grid-cols-2 gap-4">
            <x-input type="date" name="start_date" label="Tanggal Mulai" :value="isset($period) ? $period->start_date->format('Y-m-d') : ''" required />
            <x-input type="date" name="end_date" label="Tanggal Selesai" :value="isset($period) ? $period->end_date->format('Y-m-d') : ''" required />
        </div>
        <x-textarea name="description" label="Deskripsi (opsional)" rows="3">{{ $period->description ?? '' }}</x-textarea>
        <x-select name="status" label="Status" :options="['active' => 'Active', 'completed' => 'Completed']" :selected="$period->status ?? 'active'" :placeholder="null" required />
    </div>
</x-card>

<div class="flex gap-3 mt-6">
    <button type="submit" class="btn btn-primary">
        <i data-lucide="check" class="w-4 h-4"></i> Simpan Periode
    </button>
    <a href="{{ route('admin.periods.index') }}" class="btn btn-secondary">Batal</a>
</div>
