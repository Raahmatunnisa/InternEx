<?php

namespace Database\Factories;

use App\Models\Internship;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<\App\Models\Attendance>
 */
class AttendanceFactory extends Factory
{
    public function definition(): array
    {
        $status = fake()->randomElement(['hadir', 'hadir', 'hadir', 'terlambat', 'izin', 'sakit']);

        return [
            'internship_id' => Internship::factory(),
            'date' => fake()->dateTimeBetween('-1 month', 'now'),
            'check_in_time' => in_array($status, ['hadir', 'terlambat']) ? ($status === 'terlambat' ? fake()->time('H:i', '11:00') : fake()->time('H:i', '09:00')) : null,
            'check_out_time' => in_array($status, ['hadir', 'terlambat']) ? fake()->time('H:i', '18:00') : null,
            'status' => $status,
        ];
    }
}
