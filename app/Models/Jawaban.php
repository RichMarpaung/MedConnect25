<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jawaban extends Model
{
    /** @use HasFactory<\Database\Factories\JawabanFactory> */
    use HasFactory;
    public function ulasan()
    {
        return $this->belongsTo(UlasanDokter::class, 'ulasan_id');
    }
protected $fillable = [
        'ulasan_id',      // <-- INI YANG MENYEBABKAN ERROR
        'pertanyaan_id',  // Tambahkan ini juga
        'jawaban_rating', // Tambahkan ini juga
        'jawaban_teks',   // Tambahkan ini juga (untuk jaga-jaga jika ada tipe teks)
    ];
    /**
     * Satu jawaban merujuk pada satu pertanyaan.
     */
    public function pertanyaan()
    {
        return $this->belongsTo(Pertanyaan::class, 'pertanyaan_id');
    }
}
