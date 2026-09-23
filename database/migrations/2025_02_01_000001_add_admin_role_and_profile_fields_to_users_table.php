<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Menambahkan role 'admin' pada enum role users, serta kolom profil
     * tambahan (phone, photo_path) dan status aktif akun (is_active) yang
     * dibutuhkan oleh fitur manajemen akun oleh admin.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone', 30)->nullable()->after('role');
            $table->string('photo_path')->nullable()->after('phone');
            $table->boolean('is_active')->default(true)->after('photo_path');
        });

        // Enum role perlu di-widen agar menerima nilai 'admin'.
        // Dilakukan lewat raw statement karena project tidak menggunakan doctrine/dbal.
        if (Schema::getConnection()->getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('mahasiswa', 'mentor', 'admin') NOT NULL DEFAULT 'mahasiswa'");
        }
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['phone', 'photo_path', 'is_active']);
        });

        if (Schema::getConnection()->getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('mahasiswa', 'mentor') NOT NULL DEFAULT 'mahasiswa'");
        }
    }
};
