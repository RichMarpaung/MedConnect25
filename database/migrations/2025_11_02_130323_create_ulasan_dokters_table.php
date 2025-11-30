<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ulasan_dokters', function (Blueprint $table) {
            $table->id();

            // Hubungkan ke Reservasi (1 Reservasi = 1 Ulasan)
            $table->foreignId('reservasi_id')
                  ->constrained('reservations') // Sesuaikan dengan nama tabel reservasi Anda
                  ->onDelete('cascade')
                  ->unique(); // Mencegah spam ulasan ganda

            // Siapa pasiennya?
            $table->foreignId('pasien_id')
                  ->constrained('users')
                  ->onDelete('cascade');

            // Siapa dokternya?
            $table->foreignId('dokter_id')
                  ->constrained('dokters')
                  ->onDelete('cascade');

            // Kritik & Saran (Opsional, di luar pertanyaan rating)
            $table->text('komentar_umum')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ulasan_dokters');
    }
};
