<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMedicalRecordRequest;
use App\Http\Requests\UpdateMedicalRecordRequest;
use App\Models\MedicalRecord;
use App\Models\Reservation;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
class MedicalRecordController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMedicalRecordRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function download(Reservation $reservasi)
    {
        // Verifikasi kepemilikan
        if (Auth::id() !== $reservasi->pasien_id) {
            abort(403, 'Akses Ditolak');
        }

        // Muat semua data yang diperlukan
        $reservasi->load(['dokter.user', 'dokter.layanan', 'pasien', 'jadwal', 'rekamMedis']);
        $rekamMedis = $reservasi->rekamMedis;

        // Buat PDF dari view baru 'pdf.rekam-medis'
        $pdf = PDF::loadView('pdf.rekam-medis', [
            'reservasi' => $reservasi,
            'rekamMedis' => $rekamMedis
        ]);

        // Download PDF
        return $pdf->download('rekam-medis-'.$reservasi->id.'.pdf');
    }
    public function show(Reservation $reservasi)
    {
        // Pastikan user yang login adalah pemilik reservasi
        if (Auth::id() !== $reservasi->pasien_id) {
            abort(403, 'Akses Ditolak');
        }

        // Pastikan reservasi sudah 'selesai'
        if ($reservasi->status !== 'selesai') {
             return back()->with('error', 'Rekam medis hanya tersedia untuk reservasi yang telah selesai.');
        }

        // Ambil data rekam medis dari reservasi
        // 'rekamMedis' adalah nama relasi hasOne() di model Reservation Anda
        $rekamMedis = $reservasi->rekamMedis;

        // Muat data lain yang diperlukan
        $reservasi->load(['dokter.user', 'pasien']);

        // Kirim data ke view baru
        return view('medical-record.show', [
            'reservasi' => $reservasi,
            'rekamMedis' => $rekamMedis
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MedicalRecord $medicalRecord)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMedicalRecordRequest $request, MedicalRecord $medicalRecord)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MedicalRecord $medicalRecord)
    {
        //
    }
}
