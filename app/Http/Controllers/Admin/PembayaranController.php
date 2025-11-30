<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class PembayaranController extends Controller
{
    public function index()
    {
        // Memuat komponen Livewire
        return view('admin.pembayaran.index');
    }
}
