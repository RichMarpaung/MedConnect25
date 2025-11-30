<?php

namespace App\Http\Controllers;

use App\Models\Dokter;
use App\Http\Requests\StoreDokterRequest;
use App\Http\Requests\UpdateDokterRequest;

class DokterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Pastikan Anda memiliki view ini:
        // resources/views/admin/layanan/index.blade.php
        return view('admin.tenaga-medis.index');
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
    public function store(StoreDokterRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Dokter $dokter)
    {
        // $dokter otomatis diambil dari ID di URL

        // Kita muat (eager load) relasi yang ingin ditampilkan
        $dokter->load(['user', 'layanan', 'jadwal']); // 'jadwal' (singular) sesuai Model Anda

        // Kirim data ke view baru
        return view('admin.tenaga-medis.show', [
            'dokter' => $dokter
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Dokter $dokter)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDokterRequest $request, Dokter $dokter)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Dokter $dokter)
    {
        //
    }
}
