<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('final_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('internship_id')->constrained('internships')->cascadeOnDelete();
            $table->string('title')->nullable();
            $table->text('abstract')->nullable();
            $table->string('file_path')->nullable();
            $table->enum('status', ['draft', 'submitted', 'reviewed', 'approved', 'revision'])->default('draft');
            $table->timestamps();

            $table->unique('internship_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('final_reports');
    }
};
