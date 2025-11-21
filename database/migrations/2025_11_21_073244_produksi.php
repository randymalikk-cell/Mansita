<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('produksis', function (Blueprint $table) {
            $table->id(); // ID_Produksi (PK) [cite: 1559]
            $table->date('tanggal'); // Tanggal [cite: 1559]
            $table->string('shift'); // Shift [cite: 1559]
            $table->integer('jumlah_tahu_putih'); // Jumlah Tahu Putih [cite: 1559]
            $table->integer('jumlah_tahu_kuning'); // Jumlah Tahu Kuning [cite: 1560]
            
            // Relasi 1:N ke User (ID_User - FK) 
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('produksis');
    }
};
