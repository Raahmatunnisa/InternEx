<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Attendance extends Model
{
    /** @use HasFactory<\Database\Factories\AttendanceFactory> */
    use HasFactory;

    protected $fillable = [
        'internship_id',
        'date',
        'check_in_time',
        'check_out_time',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'date' => 'date',
            'check_in_time' => 'datetime:H:i',
            'check_out_time' => 'datetime:H:i',
        ];
    }

    public function internship(): BelongsTo
    {
        return $this->belongsTo(Internship::class);
    }

    /**
     * Status tampilan yang dipakai di seluruh role (Admin, Mentor, Mahasiswa).
     * Status asli di database tetap hadir/terlambat/izin/sakit/alpha, tapi
     * kalau statusnya hadir/terlambat namun jam masuk atau jam pulang belum
     * terisi, tampilkan sebagai "Lupa Absen Masuk"/"Lupa Absen Pulang" agar
     * lebih jelas ketimbang ditampilkan seolah sudah hadir penuh.
     */
    public function getDisplayStatusAttribute(): string
    {
        if (in_array($this->status, ['hadir', 'terlambat'], true)) {
            if (! $this->check_in_time) {
                return 'lupa_masuk';
            }

            if (! $this->check_out_time) {
                return 'lupa_pulang';
            }
        }

        return $this->status;
    }

    public function getDisplayLabelAttribute(): string
    {
        return match ($this->display_status) {
            'lupa_masuk' => 'Lupa Absen Masuk',
            'lupa_pulang' => 'Lupa Absen Pulang',
            default => ucfirst($this->status),
        };
    }
}
