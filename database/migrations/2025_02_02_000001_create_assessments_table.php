<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('assessments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('internship_id')->constrained('internships')->cascadeOnDelete();
            $table->foreignId('mentor_id')->constrained('users')->cascadeOnDelete();

            // Komponen nilai (input mentor, 0-100)
            $table->decimal('attendance_score', 5, 2);
            $table->decimal('logbook_score', 5, 2);
            $table->decimal('final_report_score', 5, 2);
            $table->decimal('presentation_score', 5, 2);

            // Hasil perhitungan otomatis backend (lihat App\Models\Assessment)
            $table->decimal('final_score', 5, 2);
            $table->enum('grade', ['A', 'AB', 'B', 'BC', 'C', 'D', 'E']);
            $table->decimal('grade_point', 2, 1);

            $table->timestamps();

            // Satu mahasiswa (internship) hanya memiliki satu record penilaian.
            $table->unique('internship_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('assessments');
    }
};
