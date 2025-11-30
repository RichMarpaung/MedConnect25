<?php

namespace App\Livewire\Dokter;

use Livewire\Component;
use App\Models\Reservation;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AntrianManager extends Component
{
    public $dokter;
    public $antrianHariIni;

    public function mount()
    {
        // ### PERBAIKAN DI SINI ###
        // Menggunakan 'dokterProfile' (sesuai model User Anda)
        $this->dokter = Auth::user()->dokterProfile;

        $this->loadAntrian();
    }

    public function loadAntrian()
    {
        $this->antrianHariIni = Reservation::where('dokter_id', $this->dokter->id)
            ->where('tanggal_reservasi', Carbon::today('Asia/Makassar')) // <-- INI MASALAHNYA
            ->where('status', 'dijadwalkan')
            ->with('pasien')
            ->orderBy('nomor_antrian', 'asc')
            ->get();
    }

    /**
     * Aksi untuk tombol 'Periksa'
     */
    public function periksa($reservasiId)
    {
        return redirect()->route('dokter.periksa', $reservasiId);
    }

    public function render()
    {
        return view('livewire.dokter.antrian-manager');
    }
}
