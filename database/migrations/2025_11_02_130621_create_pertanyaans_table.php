<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pertanyaans', function (Blueprint $table) {
            $table->id();

            // PENTING: Kategori untuk mengelompokkan soal (Contoh: "A. Sikap & Pelayanan")
            $table->string('kategori');

            $table->text('pertanyaan'); // Teks soal

            // Tipe jawaban (Rating 1-5 atau Isian Teks)
            $table->enum('tipe', ['rating_1_5', 'teks'])->default('rating_1_5');

            $table->integer('urutan')->default(0); // Agar urutan soal rapi
            $table->boolean('is_aktif')->default(true); // Agar bisa menonaktifkan soal lama
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pertanyaans');
    }
};
