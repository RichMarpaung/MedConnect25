<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    /** @use HasFactory<\Database\Factories\ReservationFactory> */
    use HasFactory;
    protected $fillable = [
        'pasien_id',
        'dokter_id',
        'jadwal_id',
        'tanggal_reservasi',
        'nomor_antrian',
        'status',
    ];
    protected function casts(): array
    {
        return [
            // Beri tahu Laravel untuk otomatis mengubah
            // 'tanggal_reservasi' menjadi objek Carbon
            'tanggal_reservasi' => 'date',
        ];
    }
   public function pasien()
    {
        return $this->belongsTo(User::class, 'pasien_id');
    }

    public function dokter()
    {
        return $this->belongsTo(Dokter::class, 'dokter_id');
    }

    public function jadwal()
    {
        return $this->belongsTo(Jadwal::class, 'jadwal_id');
    }

    public function rekamMedis()
    {
        return $this->hasOne(MedicalRecord::class, 'reservasi_id');
    }
public function ulasan()
    {
        // Pastikan Anda sudah membuat model 'UlasanDokter' sebelumnya
        return $this->hasOne(UlasanDokter::class, 'reservasi_id');
    }
}
