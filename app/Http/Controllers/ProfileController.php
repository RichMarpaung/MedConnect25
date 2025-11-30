<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    /**
     * Menampilkan halaman profil pengguna dan riwayat reservasi.
     */
    public function edit()
    {
        // 1. Ambil user yang sedang login
        $user = Auth::user();

        // 2. Ambil riwayat reservasi milik user tersebut
        // Kita eager-load relasi dokter, user dokter, dan layanan
        $reservasiHistory = Reservation::where('pasien_id', $user->id)
                            ->with(['dokter.user', 'dokter.layanan'])
                            ->orderBy('tanggal_reservasi', 'desc') // Tampilkan yang terbaru dulu
                            ->paginate(10); // Batasi 10 per halaman

        // 3. Kirim data ke view
        return view('profile.edit', [
            'user' => $user,
            'reservasiHistory' => $reservasiHistory
        ]);
    }
}
