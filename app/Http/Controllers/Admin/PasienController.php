<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PasienController extends Controller
{
    public function index()
    {
        // View ini akan memuat komponen Livewire
        return view('admin.pasien.index');
    }
}
