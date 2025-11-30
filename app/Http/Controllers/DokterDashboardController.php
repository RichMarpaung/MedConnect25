<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DokterDashboardController extends Controller
{
    /**
     * Menampilkan halaman dashboard utama dokter.
     */
    public function index()
    {
        return view('dokter.dashboard.index', [
            'user' => Auth::user()
        ]);
    }

    /**
     * Menampilkan halaman untuk mengisi rekam medis.
     */
    public function periksa(Reservation $reservasi)
    {
        $dokterProfil = Auth::user()->dokterProfile; // Sesuai model User Anda
        if ($reservasi->dokter_id !== $dokterProfil->id) {
            abort(403, 'Akses ditolak.');
        }

        return view('dokter.periksa', [
            'reservasi' => $reservasi
        ]);
    }

    /**
     * ### FUNGSI BARU ###
     * Menampilkan halaman riwayat pasien yang pernah diperiksa.
     */
    public function riwayat()
    {
        // View ini akan memuat komponen Livewire
        return view('dokter.riwayat.index');
    }
    public function profile()
    {
        // View ini akan memuat komponen Livewire
        return view('dokter.profile.edit');
    }
}
