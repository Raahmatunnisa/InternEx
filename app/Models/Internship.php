<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Internship extends Model
{
    /** @use HasFactory<\Database\Factories\InternshipFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'mentor_id',
        'internship_period_id',
        'division_id',
        'institution',
        'program',
        'start_date',
        'end_date',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date',
        ];
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function mentor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'mentor_id');
    }

    public function period(): BelongsTo
    {
        return $this->belongsTo(InternshipPeriod::class, 'internship_period_id');
    }

    public function division(): BelongsTo
    {
        return $this->belongsTo(Division::class);
    }

    public function logbooks(): HasMany
    {
        return $this->hasMany(Logbook::class);
    }

    public function attendances(): HasMany
    {
        return $this->hasMany(Attendance::class);
    }

    public function permits(): HasMany
    {
        return $this->hasMany(Permit::class);
    }

    public function finalReport(): HasOne
    {
        return $this->hasOne(FinalReport::class);
    }

    public function assessment(): HasOne
    {
        return $this->hasOne(Assessment::class);
    }

    /**
     * Persentase progress periode magang berdasarkan tanggal hari ini.
     */
    public function progressPercentage(): int
    {
        $start = $this->start_date;
        $end = $this->end_date;
        $today = now()->startOfDay();

        if ($today->lessThanOrEqualTo($start)) {
            return 0;
        }

        if ($today->greaterThanOrEqualTo($end)) {
            return 100;
        }

        $totalDays = max($start->diffInDays($end), 1);
        $elapsedDays = $start->diffInDays($today);

        return (int) min(100, round(($elapsedDays / $totalDays) * 100));
    }

    /**
     * Jumlah hari kerja (Senin-Jumat) yang sudah berlalu sejak mulai magang
     * sampai hari ini (atau sampai tanggal selesai jika sudah lewat).
     */
    public function workingDaysElapsed(): int
    {
        $start = $this->start_date->copy()->startOfDay();
        $end = now()->startOfDay()->min($this->end_date->copy()->startOfDay());

        if ($end->lessThan($start)) {
            return 0;
        }

        $days = 0;
        $cursor = $start->copy();

        while ($cursor->lessThanOrEqualTo($end)) {
            if (! $cursor->isWeekend()) {
                $days++;
            }
            $cursor->addDay();
        }

        return $days;
    }

    /**
     * Persentase progress pengisian logbook harian: jumlah hari kerja yang
     * sudah diisi logbook dibanding jumlah hari kerja yang sudah berjalan.
     */
    public function logbookProgressPercentage(): int
    {
        $totalWorkingDays = $this->workingDaysElapsed();

        if ($totalWorkingDays <= 0) {
            return 0;
        }

        $filledDays = $this->logbooks()->distinct('date')->count('date');

        return (int) min(100, round(($filledDays / $totalWorkingDays) * 100));
    }

    /**
     * Persentase progress laporan akhir berdasarkan status terakhir yang
     * tercatat pada tabel final_reports.
     */
    public function reportProgressPercentage(): int
    {
        return match ($this->finalReport?->status) {
            'approved' => 100,
            'reviewed' => 75,
            'revision' => 60,
            'submitted' => 50,
            'draft' => 10,
            default => 0,
        };
    }
}
