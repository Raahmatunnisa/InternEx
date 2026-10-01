<?php

namespace Database\Factories;

use App\Models\Internship;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<\App\Models\FinalReport>
 */
class FinalReportFactory extends Factory
{
    public function definition(): array
    {
        return [
            'internship_id' => Internship::factory(),
            'title' => 'Laporan Akhir Magang - '.fake()->words(3, true),
            'abstract' => fake()->paragraph(5),
            'file_path' => null,
            'status' => 'draft',
        ];
    }
}
