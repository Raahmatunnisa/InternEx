<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Assessment extends Model
{
    /** @use HasFactory<\Database\Factories\AssessmentFactory> */
    use HasFactory;

    /**
     * Bobot masing-masing komponen penilaian.
     * Dipakai untuk perhitungan final_score dan ditampilkan di halaman mahasiswa.
     */
    public const WEIGHT_ATTENDANCE = 0.10;

    public const WEIGHT_LOGBOOK = 0.20;

    public const WEIGHT_FINAL_REPORT = 0.50;

    public const WEIGHT_PRESENTATION = 0.20;

    protected $fillable = [
        'internship_id',
        'mentor_id',
        'attendance_score',
        'logbook_score',
        'final_report_score',
        'presentation_score',
        'final_score',
        'grade',
        'grade_point',
    ];

    protected function casts(): array
    {
        return [
            'attendance_score' => 'decimal:2',
            'logbook_score' => 'decimal:2',
            'final_report_score' => 'decimal:2',
            'presentation_score' => 'decimal:2',
            'final_score' => 'decimal:2',
            'grade_point' => 'decimal:1',
        ];
    }

    /**
     * Setiap kali record disimpan, final_score/grade/grade_point selalu
     * dihitung ulang dari 4 komponen. Mentor tidak pernah menginput
     * ketiga nilai ini secara langsung.
     */
    protected static function booted(): void
    {
        static::saving(function (Assessment $assessment) {
            $final = round(
                ((float) $assessment->attendance_score * self::WEIGHT_ATTENDANCE)
                + ((float) $assessment->logbook_score * self::WEIGHT_LOGBOOK)
                + ((float) $assessment->final_report_score * self::WEIGHT_FINAL_REPORT)
                + ((float) $assessment->presentation_score * self::WEIGHT_PRESENTATION),
                2
            );

            [$grade, $gradePoint] = self::resolveGrade($final);

            $assessment->final_score = $final;
            $assessment->grade = $grade;
            $assessment->grade_point = $gradePoint;
        });
    }

    /**
     * Konversi nilai akhir (0-100) menjadi [grade, grade_point] sesuai
     * boundary yang ditetapkan.
     *
     * @return array{0: string, 1: float}
     */
    public static function resolveGrade(float $score): array
    {
        return match (true) {
            $score >= 87 => ['A', 4.0],
            $score >= 78 => ['AB', 3.5],
            $score >= 69 => ['B', 3.0],
            $score >= 60 => ['BC', 2.5],
            $score >= 51 => ['C', 2.0],
            $score >= 41 => ['D', 1.0],
            default => ['E', 0.0],
        };
    }

    public function internship(): BelongsTo
    {
        return $this->belongsTo(Internship::class);
    }

    public function mentor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'mentor_id');
    }
}
