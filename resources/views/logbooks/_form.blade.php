@csrf
<div class="grid lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2 space-y-6">
        <x-card title="Informasi Aktivitas">
            <div class="space-y-5">
                <x-input name="activity" label="Judul Aktivitas" :value="$logbook->activity ?? ''" required placeholder="Contoh: Implementasi fitur login" />
                <div>
                    <x-textarea name="description" label="Deskripsi Aktivitas" rows="4" required id="description">{{ $logbook->description ?? '' }}</x-textarea>
                    <p id="description-counter" class="text-xs text-slate-400 mt-1"></p>
                </div>
            </div>
        </x-card>

        <x-card title="Waktu">
            <div class="grid sm:grid-cols-3 gap-4">
                <x-input type="date" name="date" label="Tanggal" :value="isset($logbook) ? $logbook->date->format('Y-m-d') : now()->format('Y-m-d')" required max="{{ now()->format('Y-m-d') }}" />
                <x-input type="time" name="start_time" label="Jam Mulai" :value="isset($logbook) ? $logbook->start_time->format('H:i') : ''" required />
                <x-input type="time" name="end_time" label="Jam Selesai" :value="isset($logbook) ? $logbook->end_time->format('H:i') : ''" required />
            </div>
        </x-card>

        <x-card title="Hasil & Output">
            <x-textarea name="output" label="Output / Hasil" rows="3">{{ $logbook->output ?? '' }}</x-textarea>
        </x-card>

        <x-card title="Kendala">
            <x-textarea name="obstacle" label="Kendala yang Dihadapi (opsional)" rows="3">{{ $logbook->obstacle ?? '' }}</x-textarea>
        </x-card>
    </div>

    <div class="lg:col-span-1 space-y-6">
        <x-photo-card
            context="logbook.create.side"
            quote="Setiap aktivitas adalah bagian dari perjalanan profesionalmu."
            alt="Suasana kerja tim magang"
            class="hidden lg:block"
        />
        <x-card title="Simpan Aktivitas">
            <p class="text-sm text-slate-500 mb-4">Pastikan seluruh informasi sudah benar sebelum menyimpan.</p>
            <div class="flex flex-col gap-3">
                <x-button type="submit">
                    <i data-lucide="check" class="w-4 h-4"></i> Simpan Aktivitas
                </x-button>
                <a href="{{ route('logbooks.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </x-card>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => bindCharCounter('description', 'description-counter', 5000));
</script>
