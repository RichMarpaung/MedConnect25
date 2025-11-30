<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dokter extends Model
{
    /** @use HasFactory<\Database\Factories\DokterFactory> */
    use HasFactory;
    protected $fillable = [
        'user_id',
        'layanan_id',
        'nomor_izin_praktek',    // <-- INI YANG HILANG
        'deskripsi_pengalaman', // <-- TAMBAHKAN INI JUGA
        'foto_profil',          // <-- TAMBAHKAN INI JUGA
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function jadwal()
    {
        return $this->hasMany(Jadwal::class, 'dokter_id');
    }

    public function reservasi()
    {
        return $this->hasMany(Reservation::class, 'dokter_id');
    }

    public function rekamMedis()
    {
        return $this->hasMany(MedicalRecord::class, 'dokter_id');
    }

    public function layanan()
    {
        return $this->belongsTo(Layanan::class, 'layanan_id');
    }
}
