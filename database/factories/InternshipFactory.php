<?php

namespace Database\Factories;

use App\Models\Internship;
use App\Models\InternshipPeriod;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Internship>
 */
class InternshipFactory extends Factory
{
    public function definition(): array
    {
        $start = fake()->dateTimeBetween('-3 months', '-1 month');
        $end = (clone $start)->modify('+4 months');

        return [
            'user_id' => User::factory()->mahasiswa(),
            'mentor_id' => User::factory()->mentor(),
            'internship_period_id' => InternshipPeriod::factory(),
            'institution' => fake()->company(),
            'program' => fake()->randomElement(['Software Engineering', 'Data Analyst', 'UI/UX Design', 'Digital Marketing', 'Quality Assurance']),
            'start_date' => $start,
            'end_date' => $end,
            'status' => 'active',
        ];
    }
}
