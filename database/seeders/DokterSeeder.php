<?php

namespace Database\Seeders;

use App\Models\Dokter;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DokterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       $role_dokter_id = DB::table('roles')->where('name', 'dokter')->first()->id;

        // 2. Ambil semua user yang berperan sebagai dokter
        $dokterUsers = User::where('role_id', $role_dokter_id)->get();

        // 3. ### PERUBAHAN ###
        // Ambil SEMUA ID layanan yang ada di database
        $layananIds = DB::table('layanans')->pluck('id');

        // Jika tidak ada layanan, seeder tidak bisa lanjut
        if ($layananIds->isEmpty()) {
            $this->command->error('Tabel layanan_kategori kosong. Jalankan LayananKategoriSeeder terlebih dahulu.');
            return;
        }

        // 4. Buat profil dokter untuk setiap user dokter
        foreach ($dokterUsers as $index => $user) {
            Dokter::create([
                'user_id' => $user->id,

                // ### PERUBAHAN ###
                // Gunakan ID layanan, bukan string spesialisasi
                'layanan_id' => $layananIds[$index % $layananIds->count()],

                'nomor_izin_praktek' => 'SIP-' . (123450 + $user->id), // Menjamin unik
                'deskripsi_pengalaman' => 'Berpengalaman lebih dari ' . rand(3, 10) . ' tahun.',
                'foto_profil' => null,
            ]);
        }
    }
}
