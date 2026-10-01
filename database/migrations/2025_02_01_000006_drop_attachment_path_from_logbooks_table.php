<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Fitur "Lampiran" pada halaman mahasiswa (upload dokumen pendukung
     * pada Aktivitas Harian / Logbook) sudah tidak diperlukan sehingga
     * kolom attachment_path dihapus dari tabel logbooks.
     */
    public function up(): void
    {
        Schema::table('logbooks', function (Blueprint $table) {
            if (Schema::hasColumn('logbooks', 'attachment_path')) {
                $table->dropColumn('attachment_path');
            }
        });
    }

    public function down(): void
    {
        Schema::table('logbooks', function (Blueprint $table) {
            $table->string('attachment_path')->nullable()->after('obstacle');
        });
    }
};
