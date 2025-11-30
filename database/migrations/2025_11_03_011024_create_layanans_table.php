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
        Schema::create('layanans', function (Blueprint $table) {
            $table->id();
            $table->string('nama_layanan'); // Contoh: "Kardiologi", "Dokter Umum"

            // Deskripsi singkat layanan
            $table->text('deskripsi')->nullable();

            // Untuk URL yang rapi (e.g., /layanan/kardiologi)
            $table->string('slug')->unique();
$table->string('icon')->nullable();
            // Admin bisa menonaktifkan layanan ini
            $table->boolean('is_aktif')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('layanans');
    }
};
