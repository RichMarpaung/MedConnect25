<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicalRecord extends Model
{
    /** @use HasFactory<\Database\Factories\MedicalRecordFactory> */
    use HasFactory;
    protected $fillable = [
        'reservasi_id',
        'pasien_id',
        'dokter_id',
        'subjektif',
        'objektif',
        'assessment',
        'plan',
    ];
      public function reservasi()
    {
        return $this->belongsTo(Reservation::class, 'reservasi_id');
    }

    public function pasien()
    {
        return $this->belongsTo(User::class, 'pasien_id');
    }

    public function dokter()
    {
        return $this->belongsTo(Dokter::class, 'dokter_id');
    }
}
