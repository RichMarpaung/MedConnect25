<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pertanyaan; // Pastikan menggunakan Model yang benar
use Illuminate\Support\Facades\Schema; // Import Schema untuk foreign key check

class PertanyaanSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Matikan cek Foreign Key sementara
        // Ini PENTING agar 'truncate' tidak error jika ada data di tabel 'jawabans'
        Schema::disableForeignKeyConstraints();

        // 2. Bersihkan data lama menggunakan Model
        Pertanyaan::truncate();

        // 3. Hidupkan kembali cek Foreign Key
        Schema::enableForeignKeyConstraints();

        $pertanyaan = [
            // Kategori A
            ['kategori' => 'A. Sikap & Pelayanan Dokter', 'pertanyaan' => 'Dokter bersikap ramah dan sopan saat memberikan pelayanan.'],
            ['kategori' => 'A. Sikap & Pelayanan Dokter', 'pertanyaan' => 'Dokter memberikan perhatian penuh terhadap keluhan saya.'],
            ['kategori' => 'A. Sikap & Pelayanan Dokter', 'pertanyaan' => 'Dokter memperlakukan saya dengan rasa hormat sebagai pasien.'],
            ['kategori' => 'A. Sikap & Pelayanan Dokter', 'pertanyaan' => 'Dokter menunjukkan empati terhadap kondisi kesehatan saya.'],
            ['kategori' => 'A. Sikap & Pelayanan Dokter', 'pertanyaan' => 'Dokter mendengarkan keluhan saya tanpa memotong pembicaraan.'],

            // Kategori B
            ['kategori' => 'B. Kejelasan Informasi & Komunikasi', 'pertanyaan' => 'Dokter menjelaskan kondisi kesehatan saya dengan jelas.'],
            ['kategori' => 'B. Kejelasan Informasi & Komunikasi', 'pertanyaan' => 'Penjelasan dokter mudah saya pahami.'],
            ['kategori' => 'B. Kejelasan Informasi & Komunikasi', 'pertanyaan' => 'Dokter menjawab pertanyaan saya dengan sabar dan rinci.'],
            ['kategori' => 'B. Kejelasan Informasi & Komunikasi', 'pertanyaan' => 'Dokter menjelaskan manfaat dan risiko dari tindakan atau obat yang diberikan.'],
            ['kategori' => 'B. Kejelasan Informasi & Komunikasi', 'pertanyaan' => 'Dokter memberikan instruksi perawatan lanjutan dengan jelas.'],

            // Kategori C
            ['kategori' => 'C. Kompetensi Profesional', 'pertanyaan' => 'Dokter menunjukkan pengetahuan medis yang baik.'],
            ['kategori' => 'C. Kompetensi Profesional', 'pertanyaan' => 'Dokter melakukan pemeriksaan secara teliti dan cermat.'],
            ['kategori' => 'C. Kompetensi Profesional', 'pertanyaan' => 'Dokter memberikan diagnosis yang tepat sesuai keluhan saya.'],
            ['kategori' => 'C. Kompetensi Profesional', 'pertanyaan' => 'Pengobatan atau saran yang diberikan dokter sesuai dengan kondisi saya.'],
            ['kategori' => 'C. Kompetensi Profesional', 'pertanyaan' => 'Dokter mempertimbangkan riwayat kesehatan saya sebelum memberikan tindakan.'],

            // Kategori D
            ['kategori' => 'D. Waktu & Efisiensi', 'pertanyaan' => 'Dokter memulai pemeriksaan sesuai jadwal yang ditentukan.'],
            ['kategori' => 'D. Waktu & Efisiensi', 'pertanyaan' => 'Waktu pemeriksaan yang diberikan cukup dan tidak terburu-buru.'],
            ['kategori' => 'D. Waktu & Efisiensi', 'pertanyaan' => 'Proses konsultasi berjalan dengan efisien.'],

            // Kategori E
            ['kategori' => 'E. Keseluruhan Pelayanan', 'pertanyaan' => 'Saya merasa nyaman selama berinteraksi dengan dokter.'],
            ['kategori' => 'E. Keseluruhan Pelayanan', 'pertanyaan' => 'Pelayanan dokter memenuhi harapan saya.'],
            ['kategori' => 'E. Keseluruhan Pelayanan', 'pertanyaan' => 'Saya puas dengan kinerja dokter secara keseluruhan.'],
        ];

        // 4. Masukkan data ke database
        foreach ($pertanyaan as $p) {
            Pertanyaan::create([
                'kategori' => $p['kategori'],
                'pertanyaan' => $p['pertanyaan'],
                'tipe' => 'rating_1_5', // Tipe 1-5 (Sangat Puas, Puas, ...)
                'is_aktif' => true,
            ]);
        }
    }
}
