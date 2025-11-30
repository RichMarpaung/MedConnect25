<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Reservation; // <-- Pastikan ini 'Reservation' (sesuai model Anda)
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class PaymentController extends Controller
{
    /**
     * Menampilkan halaman pembayaran (dengan QRIS).
     */
    public function show(Reservation $reservasi)
    {
        // Verifikasi: Hanya pemilik reservasi yang boleh bayar
        if (Auth::id() !== $reservasi->pasien_id) {
            abort(403, 'Akses Ditolak');
        }

        // Verifikasi: Hanya reservasi 'pending' yang boleh dibayar
        if ($reservasi->status !== 'pending_payment') {
            return redirect()->route('home')->with('error', 'Reservasi ini sudah dibayar atau kedaluwarsa.');
        }

        // Ambil harga dari layanan dokter
        // Alur: Reservasi -> Dokter -> Layanan -> Harga
        $harga =20000;

        return view('payment.show', [
            'reservasi' => $reservasi,
            'harga' => $harga
        ]);
    }

    /**
     * Mengkonfirmasi pembayaran (tombol "Saya Sudah Membayar").
     * Di dunia nyata, ini akan dicek oleh payment gateway (Midtrans, dll).
     * Di sini kita buat simulasi.
     */
    public function confirm(Reservation $reservasi)
    {
        if (Auth::id() !== $reservasi->pasien_id) {
            abort(403, 'Akses Ditolak');
        }

        // Ubah status reservasi menjadi 'dijadwalkan'
        $reservasi->update(['status' => 'dijadwalkan']);

        // Arahkan ke halaman sukses
        return redirect()->route('booking.success', $reservasi->id);
    }

    /**
     * Menampilkan halaman sukses akhir.
     */
    public function success(Reservation $reservasi)
    {
        if (Auth::id() !== $reservasi->pasien_id) {
            abort(403, 'Akses Ditolak');
        }

        // Eager load data dokter, user dokter, dan layanan dokter
        $reservasi->load(['dokter.user', 'dokter.layanan']);

        return view('booking.success', ['reservasi' => $reservasi]);
    }
// Tambahkan ini di atas file

public function downloadTicket(Reservation $reservasi)
{
    // Pastikan user hanya bisa download tiketnya sendiri
    if (Auth::id() !== $reservasi->pasien_id) {
        abort(403, 'Akses Ditolak');
    }

    // Muat data yang diperlukan
    $reservasi->load(['dokter.user', 'dokter.layanan']);

    // Buat PDF dari view
    $pdf = PDF::loadView('pdf.ticket', ['reservasi' => $reservasi]);

    // Download PDF
    return $pdf->download('tiket-reservasi-'.$reservasi->id.'.pdf');
}
}
