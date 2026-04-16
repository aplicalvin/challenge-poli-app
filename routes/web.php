<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

// Public / Guest Routes
Route::get('/', function () {
    return view('welcome');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/signup', [AuthController::class, 'showSignup'])->name('signup');
    Route::post('/signup', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected Dashboard Routes
Route::middleware(['auth'])->group(function () {
    
    // Admin Routes
    Route::middleware(['role:admin'])->prefix('admin')->group(function () {
        Route::get('/', function () {
            return view('admin.dashboard');
        })->name('admin.dashboard');

        Route::get('/poli', function () { return view('admin.poli'); })->name('admin.poli');
        Route::get('/dokter', function () { return view('admin.dokter'); })->name('admin.dokter');
        Route::get('/staff', function () { return view('admin.staff'); })->name('admin.staff');
        Route::get('/pasien', function () { return view('admin.pasien'); })->name('admin.pasien');
    });

    // Doctor & Penjadwalan Routes
    Route::middleware(['role:admin,dokter'])->prefix('penjadwalan')->group(function () {
        Route::get('/shift', function () { return view('penjadwalan.shift'); })->name('penjadwalan.shift');
        Route::get('/jadwal', function () { return view('penjadwalan.jadwal'); })->name('penjadwalan.jadwal');
    });

    // Obat Routes
    Route::middleware(['role:admin,apoteker'])->prefix('obat')->group(function () {
        Route::get('/list', function () { return view('obat.list'); })->name('obat.list');
        Route::get('/stok', function () { return view('obat.stok'); })->name('obat.stok');
    });

    // Keuangan Routes
    Route::middleware(['role:admin,kasir'])->prefix('keuangan')->group(function () {
        Route::get('/transaksi', function () { return view('keuangan.transaksi'); })->name('keuangan.transaksi');
        Route::get('/laporan', function () { return view('keuangan.laporan'); })->name('keuangan.laporan');
    });

    // Riwayat Routes
    Route::middleware(['role:dokter,pasien'])->prefix('riwayat')->group(function () {
        Route::get('/periksa', function () { return view('riwayat.periksa'); })->name('riwayat.periksa');
        Route::get('/pembayaran', function () { return view('riwayat.pembayaran'); })->name('riwayat.pembayaran');
    });

    // Role Specific Home Redirects (for the sidebar link logic)
    Route::get('/doctor', function () { return view('doctor.dashboard'); })->name('doctor.dashboard')->middleware('role:dokter');
    Route::get('/patient', function () { return view('patient.dashboard'); })->name('patient.dashboard')->middleware('role:pasien');
    Route::get('/pharmacist', function () { return view('pharmacist.dashboard'); })->name('pharmacist.dashboard')->middleware('role:apoteker');
    Route::get('/cashier', function () { return view('cashier.dashboard'); })->name('cashier.dashboard')->middleware('role:kasir');
});
