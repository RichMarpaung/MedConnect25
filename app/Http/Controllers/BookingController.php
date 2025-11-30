<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function create()
    {
        // Pastikan view ini ada
        return view('booking.create');
    }
}
