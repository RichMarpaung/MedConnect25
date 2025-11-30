<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Dokter;
use App\Models\Faq;
use App\Models\Layanan;
use Illuminate\Http\Request;

class PageController extends Controller
{
    //
   public function index()
    {
        // Ambil data lainnya
        $dokters = Dokter::with(['user', 'layanan'])->get();
        $layanans = Layanan::where('is_aktif', true)->take(3)->get();

        // ### TAMBAHKAN INI ###
        // Ambil FAQ yang aktif
        $faqs = Faq::where('is_aktif', true)->get();

        return view('index', [
            'dokters' => $dokters,
            'layanans' => $layanans,
            'faqs' => $faqs // <-- KIRIM KE VIEW
        ]);
    }
}
