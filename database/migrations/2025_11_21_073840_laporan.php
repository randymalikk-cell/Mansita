<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('laporans', function (Blueprint $table) {
            $table->id(); // ID_Laporan (PK) [cite: 1566]
            $table->enum('jenis', ['produksi', 'pengeluaran']); // Jenis (produksi/pengeluaran) [cite: 1566]
            $table->date('tanggal'); // Tanggal [cite: 1566]
            $table->text('keterangan')->nullable(); // Keterangan [cite: 1566]
            $table->enum('format', ['PDF', 'Excel']); // Format (PDF/Excel) [cite: 1567]

            // Relasi N:1 ke User (Dibuat oleh - FK) 
            $table->foreignId('dibuat_oleh_user_id')->constrained('users')->onDelete('cascade');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('laporans');
    }
};
