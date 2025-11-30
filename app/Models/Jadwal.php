<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    /** @use HasFactory<\Database\Factories\JadwalFactory> */
    use HasFactory;
    protected $fillable = [
        'hari',
        'jam_mulai',
        'jam_selesai',
        'kuota_pasien',
        'dokter_id', // Diperlukan jika Anda create via Jadwal::create
    ];
    public function dokter()
    {
        return $this->belongsTo(Dokter::class, 'dokter_id');
    }

    public function reservasi()
    {
        return $this->hasMany(Reservation::class, 'jadwal_id');
    }
}
