<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
   public function showLoginForm()
    {
        // Asumsi file blade Anda ada di resources/views/auth/login.blade.php
        return view('auth.login');
    }

    /**
     * Menangani proses registrasi akun baru.
     */
    public function register(Request $request)
    {
        // 1. Validasi input
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',

            // ### TAMBAHKAN VALIDASI NOMOR TELEPON ###
            'nomor_telepon' => 'required|string|min:10|max:15',

            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput()->with('show_register', true);
        }

        // 2. Cari role 'user'
        $userRole = DB::table('roles')->where('name', 'user')->first();
        if (!$userRole) {
            return back()->withErrors(['email' => 'Gagal mendaftar, konfigurasi sistem bermasalah.'])->withInput();
        }

        // 3. Buat user baru
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,

            // ### TAMBAHKAN NOMOR TELEPON KE CREATE ###
            'nomor_telepon' => $request->nomor_telepon,

            'password' => Hash::make($request->password),
            'role_id' => $userRole->id,
        ]);

        // 4. Redirect ke login dengan pesan sukses
        return redirect()->route('login')
            ->with('success', 'Registrasi berhasil! Silakan login dengan akun Anda.');
    }
    /**
     * Menangani proses login.
     */

public function login(Request $request)
    {
        // 1. Validasi input
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        // 2. Siapkan credentials
        $credentials = $request->only('email', 'password');

        // 3. Coba lakukan autentikasi
        if (Auth::attempt($credentials)) {
            // 4. Jika sukses, regenerate session
            $request->session()->regenerate();
            $user = Auth::user();
            if ($user->role && $user->role->name == 'admin') {

                // Jika role adalah 'admin', arahkan ke /admin/dashboard
                return redirect()->intended('/admin/dashboard');

            }elseif ($user->role && $user->role->name == 'dokter') {

                // Jika role adalah 'admin', arahkan ke /admin/dashboard
                return redirect()->intended('/dokter/dashboard');

            } else {
                return redirect()->intended('/');

            }

        }
        throw ValidationException::withMessages([
            'email' => 'Email atau password yang Anda masukkan salah.',
        ]);
    }


    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login'); // Redirect ke halaman utama
    }

}
