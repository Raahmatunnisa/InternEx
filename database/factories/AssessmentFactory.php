<?php

namespace Database\Factories;

use App\Models\Assessment;
use App\Models\Internship;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Assessment>
 */
class AssessmentFactory extends Factory
{
    public function definition(): array
    {
        return [
            'internship_id' => Internship::factory(),
            'mentor_id' => User::factory()->mentor(),
            'attendance_score' => 80,
            'logbook_score' => 80,
            'final_report_score' => 80,
            'presentation_score' => 80,
            // final_score/grade/grade_point dihitung ulang otomatis oleh
            // Assessment::booted() saat disimpan, nilai di sini hanya placeholder.
            'final_score' => 0,
            'grade' => 'E',
            'grade_point' => 0,
        ];
    }
}
