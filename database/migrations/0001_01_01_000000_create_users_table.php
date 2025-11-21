<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id(); // ID_User (PK) 
            $table->string('username')->unique(); // Username 
            $table->string('email')->unique()->nullable(); // Ditambahkan untuk kebutuhan 2FA [cite: 1489]
            $table->string('password'); // Password [cite: 1558]
            $table->string('nama'); // Nama [cite: 1558]
            $table->enum('role', ['admin', 'staf produksi', 'pengurus']); // Role [cite: 1558]
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
