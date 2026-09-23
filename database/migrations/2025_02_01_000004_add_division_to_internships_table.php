<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Penempatan mahasiswa (bagian/divisi) ditentukan oleh admin dan melekat
     * pada data magang (internship) mahasiswa, bukan pada akun user secara
     * langsung, supaya penempatan tidak tercampur antar periode.
     */
    public function up(): void
    {
        Schema::table('internships', function (Blueprint $table) {
            $table->foreignId('division_id')->nullable()->after('internship_period_id')
                ->constrained('divisions')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('internships', function (Blueprint $table) {
            $table->dropConstrainedForeignId('division_id');
        });
    }
};
