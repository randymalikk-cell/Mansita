<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Ubah enum 'jenis' untuk menambahkan 'pengeluaran'
        Schema::table('transaksis', function (Blueprint $table) {
            // Untuk MySQL, ubah kolom enum menjadi VARCHAR
            DB::statement("ALTER TABLE transaksis MODIFY COLUMN jenis VARCHAR(50) NOT NULL");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transaksis', function (Blueprint $table) {
            DB::statement("ALTER TABLE transaksis MODIFY COLUMN jenis ENUM('penjualan', 'pemasukan') NOT NULL");
        });
    }
};
