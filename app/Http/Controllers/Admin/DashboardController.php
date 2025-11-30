<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dokter;
use App\Models\Layanan;
use App\Models\Reservation;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Menampilkan halaman dashboard admin.
     */
    public function index()
    {
        // 1. Ambil jumlah tenaga medis
        $jumlahTenagaMedis = Dokter::count();

        // 2. Ambil jumlah layanan
        $jumlahLayanan = Layanan::count();

        // 3. Ambil jumlah reservasi (yang sudah terkonfirmasi/dijadwalkan)
        $jumlahReservasi = Reservation::where('status', 'dijadwalkan')->count();

        // Kirim data ke view
        return view('admin.dashboard.index', [
            'jumlahTenagaMedis' => $jumlahTenagaMedis,
            'jumlahLayanan' => $jumlahLayanan,
            'jumlahReservasi' => $jumlahReservasi,
        ]);
    }
}
