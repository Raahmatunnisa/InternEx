<?php

namespace Database\Factories;

use App\Models\Logbook;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<\App\Models\LogbookFeedback>
 */
class LogbookFeedbackFactory extends Factory
{
    public function definition(): array
    {
        return [
            'logbook_id' => Logbook::factory(),
            'mentor_id' => User::factory()->mentor(),
            'feedback' => fake()->sentence(12),
        ];
    }
}
