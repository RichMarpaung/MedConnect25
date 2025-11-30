<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class LayananSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       $now = Carbon::now();

        $layanans = [
            ['nama' => 'Dokter Umum', 'icon' => 'fas fa-stethoscope'],
            ['nama' => 'Dokter Gigi', 'icon' => 'fas fa-tooth'],
            ['nama' => 'Laboratorium', 'icon' => 'fas fa-vial'],
            ['nama' => 'Kardiologi (Jantung)', 'icon' => 'fas fa-heartbeat'],
            ['nama' => 'Dermatologi (Kulit)', 'icon' => 'fas fa-allergies'],
            ['nama' => 'Pediatri (Anak)', 'icon' => 'fas fa-child'],
        ];

        $data = [];
        foreach ($layanans as $layanan) {
            $data[] = [
                'nama_layanan' => $layanan['nama'],
                'slug' => Str::slug($layanan['nama']),
                'deskripsi' => 'Layanan profesional untuk '.$layanan['nama'],
                'icon' => $layanan['icon'],
                // 'harga' => rand(50000, 200000), // <-- HAPUS BARIS INI
                'is_aktif' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        // Pastikan insert ke tabel 'layanans'
        DB::table('layanans')->insert($data);
    }
}
