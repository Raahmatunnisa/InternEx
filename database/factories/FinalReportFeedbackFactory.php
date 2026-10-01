<?php

namespace Database\Factories;

use App\Models\FinalReport;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<\App\Models\FinalReportFeedback>
 */
class FinalReportFeedbackFactory extends Factory
{
    public function definition(): array
    {
        return [
            'final_report_id' => FinalReport::factory(),
            'mentor_id' => User::factory()->mentor(),
            'feedback' => fake()->sentence(12),
        ];
    }
}
