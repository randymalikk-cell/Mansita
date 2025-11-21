<?php



use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stoks', function (Blueprint $table) {
            $table->id(); // ID_Stok (PK) [cite: 1561]
            $table->date('tanggal_update'); // Tanggal Update [cite: 1561]
            $table->integer('total_tahu_putih'); // Total Tahu Putih [cite: 1561]
            $table->integer('total_tahu_kuning'); // Total Tahu Kuning 
            
            // Relasi 1:1 ke Produksi (ID_Produksi - FK) [cite: 1562, 1568]
            $table->foreignId('produksi_id')->constrained('produksis')->unique()->onDelete('cascade');
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stoks');
    }
};
