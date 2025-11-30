<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckIfAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Cek jika user sudah login DAN rolenya adalah 'admin'
        if (Auth::check() && Auth::user()->role && Auth::user()->role->name == 'admin') {
            // Jika ya, lanjutkan ke halaman admin
            return $next($request);
        }

        // Jika tidak, tendang kembali ke halaman utama
        return redirect('/')->with('error', 'Anda tidak memiliki hak akses Admin.');
    }
}
