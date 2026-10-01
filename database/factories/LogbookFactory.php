<?php

namespace Database\Factories;

use App\Models\Internship;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<\App\Models\Logbook>
 */
class LogbookFactory extends Factory
{
    public function definition(): array
    {
        $start = fake()->time('H:i');

        return [
            'internship_id' => Internship::factory(),
            'date' => fake()->dateTimeBetween('-1 month', 'now'),
            'start_time' => $start,
            'end_time' => date('H:i', strtotime($start.' +8 hours')),
            'activity' => fake()->randomElement([
                'Implementasi fitur baru pada aplikasi',
                'Melakukan riset kebutuhan pengguna',
                'Code review bersama tim',
                'Perbaikan bug pada modul laporan',
                'Rapat koordinasi tim harian',
                'Dokumentasi teknis fitur',
            ]),
            'description' => fake()->paragraph(3),
            'output' => fake()->sentence(10),
            'obstacle' => fake()->optional(0.4)->sentence(8),
            'status' => fake()->randomElement(['submitted', 'approved', 'approved', 'rejected']),
        ];
    }
}
