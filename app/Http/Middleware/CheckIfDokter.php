<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth; // <-- Impor Auth

class CheckIfDokter
{
    public function handle(Request $request, Closure $next): Response
    {
        // Cek jika user login DAN rolenya adalah 'dokter'
        if (Auth::check() && Auth::user()->role && Auth::user()->role->name == 'dokter') {
            return $next($request);
        }

        // Jika tidak, tendang ke halaman utama
        return redirect('/')->with('error', 'Anda tidak memiliki hak akses Dokter.');
    }
}
