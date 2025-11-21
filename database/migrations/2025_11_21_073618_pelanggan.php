<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pelanggans', function (Blueprint $table) {
            $table->id(); // ID_Pelanggan (PK) 
            $table->string('nama_pelanggan'); // Nama Pelanggan [cite: 1563]
            $table->text('alamat'); // Alamat [cite: 1563]
            $table->string('kontak'); // Kontak [cite: 1563]
            $table->string('jadwal_pengiriman'); // Jadwal Pengiriman [cite: 1563]
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pelanggans');
    }
};
