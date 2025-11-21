<?php



use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('backups', function (Blueprint $table) {
            $table->id(); // ID_Backup (PK) 
            $table->dateTime('tanggal'); // Tanggal 
            $table->enum('jenis', ['otomatis', 'manual']); // Jenis (Otomatis/Manual) 
            $table->string('file_backup'); // File Backup (path atau lokasi) [cite: 1569]
            
            // Relasi N:1 ke User (Dibuat oleh - FK) [cite: 1569, 1568]
            $table->foreignId('dibuat_oleh_user_id')->constrained('users')->onDelete('cascade');
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('backups');
    }
};
