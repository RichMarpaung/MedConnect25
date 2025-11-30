<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jawabans', function (Blueprint $table) {
            $table->id();

            // Link ke Header Ulasan
            $table->foreignId('ulasan_id')
                  ->constrained('ulasan_dokters')
                  ->onDelete('cascade');

            // Link ke Soal Pertanyaan
            $table->foreignId('pertanyaan_id')
                  ->constrained('pertanyaans')
                  ->onDelete('cascade');

            // Menyimpan Skor (1 = Sangat Tidak Setuju ... 5 = Sangat Setuju)
            $table->unsignedTinyInteger('jawaban_rating')->nullable();

            // Jika tipe soalnya esai/teks
            $table->text('jawaban_teks')->nullable();

            // Mencegah 1 pertanyaan dijawab 2 kali dalam 1 sesi ulasan
            $table->unique(['ulasan_id', 'pertanyaan_id']);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jawabans');
    }
};
