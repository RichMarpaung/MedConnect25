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
        Schema::table('dokters', function (Blueprint $table) {
            //
            $table->foreignId('layanan_id')
                  ->nullable() // Boleh null jika dokter belum dikategorikan
                  ->after('user_id') // (Opsional) Menempatkannya setelah user_id
                  ->constrained('layanans') // Menghubungkan ke tabel 'layanan_kategori'
                  ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
   public function down(): void
    {
        Schema::table('dokters', function (Blueprint $table) {

            // 1. Kembalikan kolom 'spesialisasi'

            // 2. Hapus foreign key dan kolom 'layanan_kategori_id'
            $table->dropConstrainedForeignId('layanans_id');
        });
    }
};
