<?php

namespace App\Livewire\Dokter;

use Livewire\Component;
use App\Models\Reservation;
use App\Models\MedicalRecord; // Pastikan Anda punya model ini
use Illuminate\Support\Facades\Auth;

class FormRekamMedis extends Component
{
    public Reservation $reservasi; // Menerima data reservasi

    // Properti untuk form SOAP
    public $subjektif;
    public $objektif;
    public $assessment;
    public $plan;

    // Untuk mengecek apakah sudah ada
    public $existingRecord;

    protected $rules = [
        'subjektif' => 'required|string',
        'objektif' => 'required|string',
        'assessment' => 'required|string',
        'plan' => 'required|string',
    ];

    public function mount(Reservation $reservasi)
    {
        $this->reservasi = $reservasi;

        // Cek apakah rekam medis sudah pernah diisi
        $this->existingRecord = MedicalRecord::where('reservasi_id', $this->reservasi->id)->first();

        if($this->existingRecord) {
            $this->subjektif = $this->existingRecord->subjektif;
            $this->objektif = $this->existingRecord->objektif;
            $this->assessment = $this->existingRecord->assessment;
            $this->plan = $this->existingRecord->plan;
        }
    }

    public function saveRekamMedis()
    {
        $this->validate();

        // 1. Simpan (atau perbarui) rekam medis
        MedicalRecord::updateOrCreate(
            ['reservasi_id' => $this->reservasi->id], // Kunci pencarian
            [
                'pasien_id' => $this->reservasi->pasien_id,
                'dokter_id' => $this->reservasi->dokter_id,
                'subjektif' => $this->subjektif,
                'objektif' => $this->objektif,
                'assessment' => $this->assessment,
                'plan' => $this->plan,
            ]
        );

        // 2. Tandai reservasi sebagai 'selesai'
        $this->reservasi->update(['status' => 'selesai']);

        session()->flash('message', 'Rekam medis berhasil disimpan. Reservasi telah ditandai selesai.');

        // 3. Arahkan kembali ke dashboard dokter
        return redirect()->route('dokter.dashboard');
    }

    public function render()
    {
        return view('livewire.dokter.form-rekam-medis');
    }
}
