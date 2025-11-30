<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Admin\PasienController;
use App\Http\Controllers\Admin\PembayaranController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\DokterController;
use App\Http\Controllers\DokterDashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\LayananController;
use App\Http\Controllers\MedicalRecordController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\SurveyController;
use App\Http\Middleware\CheckIfAdmin;
use App\Http\Middleware\CheckIfDokter;
use Illuminate\Support\Facades\Route;




















Route::get('/', [PageController::class, 'index'])->name('home');



// Menampilkan halaman login
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login')->middleware('guest');

// Memproses data dari form login
Route::post('/login', [AuthController::class, 'login'])->name('login.submit')->middleware('guest');

// Memproses data dari form register
Route::post('/register', [AuthController::class, 'register'])->name('register.submit')->middleware('guest');

// Memproses logout
// Biasanya diletakkan di rute yang butuh login (middleware 'auth')
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');


Route::get('/booking', [BookingController::class, 'create'])
    ->middleware('auth') // Memastikan hanya user login yang bisa booking
    ->name('booking.create');

Route::get('/pembayaran/{reservasi}', [PaymentController::class, 'show'])
    ->name('payment.show')
    ->middleware('auth');

Route::post('/pembayaran/{reservasi}/konfirmasi', [PaymentController::class, 'confirm'])
    ->name('payment.confirm')
    ->middleware('auth');

Route::get('/booking-sukses/{reservasi}', [PaymentController::class, 'success'])
    ->name('booking.success')
    ->middleware('auth');

Route::get('/booking-sukses/{reservasi}/download', [PaymentController::class, 'downloadTicket'])
    ->name('booking.download')
    ->middleware('auth');


Route::get('/profile', [ProfileController::class, 'edit'])
    ->name('profile.edit')
    ->middleware('auth');
Route::get('/survey/isi/{reservasi}', [SurveyController::class, 'create'])->name('survey.create');
Route::post('/reservasi/{reservasi}/batal', [ReservationController::class, 'cancel'])
    ->name('reservation.cancel')
    ->middleware('auth');

// Rute untuk tombol "Rekam Medis"
Route::get('/rekam-medis/{reservasi}', [MedicalRecordController::class, 'show'])
    ->name('medical-record.show')
    ->middleware('auth');
Route::get('/rekam-medis/{reservasi}/download', [MedicalRecordController::class, 'download'])
     ->name('medical-record.download')
     ->middleware('auth');

Route::group(['middleware' => ['auth', \App\Http\Middleware\CheckIfAdmin::class], 'prefix' => 'admin'], function () {
Route::get('/pembayaran', [PembayaranController::class, 'index'])->name('admin.pembayaran.index');
    // ### TAMBAHKAN RUTE INI ###
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/survey', [SurveyController::class, 'index'])->name('admin.survey.index');
Route::get('/faq', [FaqController::class, 'index'])->name('admin.faq.index');
    // ... (Rute Anda yang lain)
    Route::get('/tenaga-medis', [DokterController::class, 'index'])->name('admin.tenaga-medis');
    Route::get('/tenaga-medis/{dokter}', [DokterController::class, 'show'])->name('admin.tenaga-medis.show');
    Route::get('/tenaga-medis/{dokter}/jadwal', [JadwalController::class, 'index'])
        ->name('admin.jadwal.index');
    Route::get('/layanan', [LayananController::class, 'index'])->name('admin.layanan.index');
    Route::get('/pasien', [PasienController::class, 'index'])->name('admin.pasien.index');
});

Route::group([ 'middleware' => ['auth', \App\Http\Middleware\CheckIfDokter::class],'prefix' => 'dokter','as' => 'dokter.'], function () {

    // Rute untuk halaman utama dashboard
    Route::get('/dashboard', [DokterDashboardController::class, 'index'])->name('dashboard');

    // Rute untuk halaman 'Periksa' (rekam medis)
    Route::get('/periksa/{reservasi}', [DokterDashboardController::class, 'periksa'])->name('periksa');
    Route::get('/riwayat', [DokterDashboardController::class, 'riwayat'])->name('riwayat');
    Route::get('/profile', [DokterDashboardController::class, 'profile'])->name('profile');
});
