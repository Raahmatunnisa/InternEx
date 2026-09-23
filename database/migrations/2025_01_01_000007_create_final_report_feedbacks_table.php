<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('final_report_feedbacks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('final_report_id')->constrained('final_reports')->cascadeOnDelete();
            $table->foreignId('mentor_id')->constrained('users')->cascadeOnDelete();
            $table->text('feedback');
            $table->timestamps();

            $table->index('final_report_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('final_report_feedbacks');
    }
};
