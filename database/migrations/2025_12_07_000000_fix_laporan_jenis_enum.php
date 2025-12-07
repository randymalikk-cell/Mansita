<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Ubah enum 'jenis' untuk menambahkan 'keuangan'
        Schema::table('laporans', function (Blueprint $table) {
            // Untuk MySQL, kita perlu mengubah kolom enum
            // Menggunakan raw statement untuk menghindari masalah dengan enum
            DB::statement("ALTER TABLE laporans MODIFY COLUMN jenis VARCHAR(50) NOT NULL");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('laporans', function (Blueprint $table) {
            DB::statement("ALTER TABLE laporans MODIFY COLUMN jenis ENUM('produksi', 'pengeluaran') NOT NULL");
        });
    }
};
