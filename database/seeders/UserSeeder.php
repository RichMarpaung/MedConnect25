<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Ambil ID dari masing-masing Role
        $role_admin = DB::table('roles')->where('name', 'admin')->first()->id;
        $role_dokter = DB::table('roles')->where('name', 'dokter')->first()->id;
        $role_user = DB::table('roles')->where('name', 'user')->first()->id;

        // 2. Buat 1 User Admin
        User::create([
            'name' => 'Admin Klinik',
            'email' => 'admin@klinik.com',
            'password' => Hash::make('password'), // password: "password"
            'nomor_telepon' => '081000000001',
            'role_id' => $role_admin,
            'email_verified_at' => Carbon::now(),
        ]);

        // 3. Buat 5 User untuk Dokter
        // Kita akan gunakan user ini di DokterSeeder
        for ($i = 1; $i <= 5; $i++) {
            User::create([
                'name' => 'Dr. ' . fake()->name(),
                'email' => 'dokter' . $i . '@klinik.com',
                'password' => Hash::make('password'),
                'nomor_telepon' => fake()->phoneNumber(),
                'role_id' => $role_dokter,
                'email_verified_at' => Carbon::now(),
            ]);
        }

        // 4. Buat 10 User Pasien (sesuai permintaan)
        // Kita gunakan factory untuk data acak
        User::factory(10)->create([
            'role_id' => $role_user
        ]);
    }

}
