<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UlasanDokter extends Model
{
    /** @use HasFactory<\Database\Factories\UlasanDokterFactory> */
    use HasFactory;

    protected $fillable = [
        'reservasi_id',   // <-- Ini yang menyebabkan error Anda
        'pasien_id',      // Kita tambahkan ini sekalian agar tidak error berikutnya
        'dokter_id',      // Ini juga
        'komentar_umum',  // Dan ini
    ];
    public function reservasi()
    {
        // Menyesuaikan dengan nama model 'Reservation' dari contoh Anda
        return $this->belongsTo(Reservation::class, 'reservasi_id');
    }

    /**
     * Satu ulasan diberikan oleh satu pasien.
     */
    public function pasien()
    {
        return $this->belongsTo(User::class, 'pasien_id');
    }

    /**
     * Satu ulasan diberikan untuk satu dokter.
     */
    public function dokter()
    {
        // Menyesuaikan dengan nama model 'Dokter' dari contoh Anda
        return $this->belongsTo(Dokter::class, 'dokter_id');
    }

    /**
     * Satu ulasan memiliki banyak jawaban.
     */
    public function jawaban()
    {
        return $this->hasMany(Jawaban::class, 'ulasan_id');
    }
}
