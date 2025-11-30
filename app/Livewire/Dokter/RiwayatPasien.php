<?php

namespace App\Livewire\Dokter;

use Livewire\Component;
use App\Models\Reservation;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;

class RiwayatPasien extends Component
{
    use WithPagination;
    public $search = '';
    protected $paginationTheme = 'bootstrap';

    public function render()
    {
        // 1. Dapatkan ID profil dokter yang sedang login
        $dokterId = Auth::user()->dokterProfile->id;

        // 2. Ambil semua reservasi yang sudah 'selesai'
        $riwayat = Reservation::where('dokter_id', $dokterId)
                    ->where('status', 'selesai')
                    // Ambil relasi yang diperlukan
                    ->with(['pasien', 'rekamMedis'])
                    // Logika pencarian berdasarkan nama pasien
                    ->whereHas('pasien', function($query) {
                        $query->where('name', 'like', '%'.$this->search.'%');
                    })
                    ->orderBy('tanggal_reservasi', 'desc') // Tampilkan yang terbaru
                    ->paginate(10); // 10 data per halaman

        return view('livewire.dokter.riwayat-pasien', [
            'riwayat' => $riwayat
        ]);
    }
}
