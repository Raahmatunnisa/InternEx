<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('internships', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('mentor_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('internship_period_id')->constrained('internship_periods')->cascadeOnDelete();
            $table->string('institution');
            $table->string('program');
            $table->date('start_date');
            $table->date('end_date');
            $table->enum('status', ['active', 'completed'])->default('active');
            $table->timestamps();

            $table->unique('user_id');
            $table->index('mentor_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('internships');
    }
};
