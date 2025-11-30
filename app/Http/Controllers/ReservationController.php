<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreReservationRequest;
use App\Http\Requests\UpdateReservationRequest;
use App\Models\Reservation;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
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
    public function store(StoreReservationRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Reservation $reservation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Reservation $reservation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateReservationRequest $request, Reservation $reservation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Reservation $reservation)
    {
        //
    }
    public function cancel(Reservation $reservasi)
    {
        // Pastikan user yang login adalah pemilik reservasi
        if (Auth::id() !== $reservasi->pasien_id) {
            abort(403, 'Akses Ditolak');
        }

        // Hanya reservasi 'pending' yang boleh dibatalkan
        if ($reservasi->status == 'pending_payment') {
            $reservasi->update(['status' => 'dibatalkan']);
            return back()->with('success', 'Reservasi (ID: '.$reservasi->id.') telah berhasil dibatalkan.');
        }

        return back()->with('error', 'Reservasi ini tidak dapat dibatalkan.');
    }
}
