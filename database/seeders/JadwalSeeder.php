<?php

namespace Database\Seeders;

use App\Models\Dokter;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JadwalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dokters = Dokter::all();

        // 3. Siapkan data jadwal dalam array
        $jadwals = [];
        $now = Carbon::now();

        // 4. Loop untuk setiap dokter
        foreach ($dokters as $dokter) {

            // Jadwal 1: Senin Pagi
            $jadwals[] = [
                'dokter_id' => $dokter->id,
                'hari' => 'Senin',
                'jam_mulai' => '09:00:00',
                'jam_selesai' => '12:00:00',
                'kuota_pasien' => rand(10, 15),
                'created_at' => $now,
                'updated_at' => $now,
            ];

            // Jadwal 2: Rabu Pagi
            $jadwals[] = [
                'dokter_id' => $dokter->id,
                'hari' => 'Rabu',
                'jam_mulai' => '09:00:00',
                'jam_selesai' => '12:00:00',
                'kuota_pasien' => rand(10, 15),
                'created_at' => $now,
                'updated_at' => $now,
            ];

            // Jadwal 3: Jumat Sore
            $jadwals[] = [
                'dokter_id' => $dokter->id,
                'hari' => 'Jumat',
                'jam_mulai' => '14:00:00',
                'jam_selesai' => '17:00:00',
                'kuota_pasien' => rand(15, 20),
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        // 5. Masukkan semua data ke database dalam satu query
        DB::table('jadwals')->insert($jadwals);
    }
}
