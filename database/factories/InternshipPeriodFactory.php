<?php

namespace Database\Factories;

use App\Models\InternshipPeriod;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<InternshipPeriod>
 */
class InternshipPeriodFactory extends Factory
{
    public function definition(): array
    {
        $start = fake()->dateTimeBetween('-3 months', 'now');
        $end = (clone $start)->modify('+4 months');

        return [
            'name' => 'Magang '.fake()->randomElement(['Ganjil', 'Genap']).' '.fake()->year(),
            'start_date' => $start,
            'end_date' => $end,
            'description' => fake()->sentence(12),
            'status' => 'active',
        ];
    }

    public function completed(): static
    {
        return $this->state(fn () => ['status' => 'completed']);
    }
}
