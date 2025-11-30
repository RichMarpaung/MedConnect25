<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Layanan extends Model
{
    /** @use HasFactory<\Database\Factories\LayananFactory> */
    use HasFactory;
    protected $fillable = [
        'nama_layanan',
        'deskripsi',
        'slug',
        'icon',
        'is_aktif',
    ];

    /**
     * Relasi: Satu Kategori Layanan memiliki banyak Dokter.
     */
    public function dokter()
    {
        // Pastikan nama model Dokter Anda adalah 'Dokter'
        // dan foreign key di tabel 'dokters' adalah 'layanan_kategori_id'
        return $this->hasMany(Dokter::class, 'layanan_id');
    }
}
