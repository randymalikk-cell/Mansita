<?php

// database/migrations/xxxx_xx_xx_xxxxxx_create_transaksis_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transaksis', function (Blueprint $table) {
            $table->id(); // ID_Transaksi (PK) [cite: 1564]
            $table->date('tanggal'); // Tanggal [cite: 1564]
            $table->enum('jenis', ['penjualan', 'pemasukan']); // Jenis (penjualan/pemasukan) [cite: 1564]
            $table->decimal('jumlah', 10, 2); // Jumlah (Menggunakan decimal untuk nilai uang/jumlah) [cite: 1564]
            $table->text('keterangan')->nullable(); // Keterangan [cite: 1564]
            
            // Relasi N:1 ke Pelanggan (ID_Pelanggan - FK) 
            $table->foreignId('pelanggan_id')->constrained('pelanggans')->onDelete('cascade');
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transaksis');
    }
};
