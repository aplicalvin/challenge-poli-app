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
        Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('admin.dashboard');

        Route::resource('poli', App\Http\Controllers\PoliController::class)->names([
            'index' => 'admin.poli'
        ]);
        Route::resource('dokter', App\Http\Controllers\DokterController::class)->names([
            'index' => 'admin.dokter'
        ]);
        Route::resource('staff', App\Http\Controllers\StaffController::class)->names([
            'index' => 'admin.staff'
        ]);
        Route::resource('pasien', App\Http\Controllers\PasienController::class)->names([
            'index' => 'admin.pasien'
        ]);
        Route::resource('users', App\Http\Controllers\UserController::class)->names([
            'index' => 'admin.users'
        ]);
    });

    // Doctor & Penjadwalan Routes
    Route::middleware(['role:admin,dokter'])->prefix('penjadwalan')->group(function () {
        Route::resource('shift', App\Http\Controllers\ShiftController::class)->names([
            'index' => 'penjadwalan.shift'
        ]);
        Route::resource('ruang', App\Http\Controllers\RuangController::class)->names([
            'index' => 'penjadwalan.ruang'
        ]);
        Route::resource('jadwal', App\Http\Controllers\JadwalJagaController::class)->names([
            'index' => 'penjadwalan.jadwal',
            'store' => 'penjadwalan.jadwal.store',
            'update' => 'penjadwalan.jadwal.update',
            'destroy' => 'penjadwalan.jadwal.destroy',
        ]);
    });

    // Obat Routes
    Route::middleware(['role:admin,apoteker'])->prefix('obat')->group(function () {
        Route::get('/stok', [App\Http\Controllers\ObatController::class, 'stok'])->name('obat.stok');
        Route::resource('list', App\Http\Controllers\ObatController::class)->names([
            'index' => 'obat.list',
            'store' => 'obat.list.store',
            'update' => 'obat.list.update',
            'destroy' => 'obat.list.destroy',
        ])->parameters(['list' => 'obat']);
    });

    // Keuangan Routes
    Route::middleware(['role:admin,kasir'])->prefix('keuangan')->group(function () {
        Route::get('/transaksi', function () {
            return view('keuangan.transaksi');
        })->name('keuangan.transaksi');
        Route::get('/laporan', function () {
            return view('keuangan.laporan');
        })->name('keuangan.laporan');
    });

    // Riwayat Routes
    Route::middleware(['role:dokter,pasien'])->prefix('riwayat')->group(function () {
        Route::get('/periksa', function () {
            return view('riwayat.periksa');
        })->name('riwayat.periksa');
        Route::get('/pembayaran', function () {
            return view('riwayat.pembayaran');
        })->name('riwayat.pembayaran');
    });

    // Role Specific Home Redirects (for the sidebar link logic)
    Route::get('/doctor', function () {
        return view('doctor.dashboard');
    })->name('doctor.dashboard')->middleware('role:dokter');
    Route::get('/doctor/antrian', [App\Http\Controllers\LayananDokterController::class, 'index'])->name('dokter.antrian')->middleware('role:dokter');
    Route::post('/doctor/antrian/{id}/start', [App\Http\Controllers\LayananDokterController::class, 'startExamine'])->name('doctor.queue.start')->middleware('role:dokter');
    Route::get('/doctor/antrian/{id}/examine', [App\Http\Controllers\LayananDokterController::class, 'examine'])->name('doctor.queue.examine')->middleware('role:dokter');
    Route::post('/doctor/antrian/{id}/finish', [App\Http\Controllers\LayananDokterController::class, 'finishExamine'])->name('doctor.queue.finish')->middleware('role:dokter');
    Route::get('/doctor/riwayat', [App\Http\Controllers\RiwayatPeriksaDokterController::class, 'index'])->name('doctor.riwayat')->middleware('role:dokter');
    Route::get('/doctor/riwayat/{id}', [App\Http\Controllers\RiwayatPeriksaDokterController::class, 'detail'])->name('doctor.riwayat.detail')->middleware('role:dokter');

    Route::get('/patient/registration', [App\Http\Controllers\DaftarPeriksaController::class, 'index'])->name('patient.registration.index')->middleware('role:pasien');
    Route::get('/patient/registration/schedules', [App\Http\Controllers\DaftarPeriksaController::class, 'getSchedules'])->name('patient.registration.schedules')->middleware('role:pasien');
    Route::post('/patient/registration', [App\Http\Controllers\DaftarPeriksaController::class, 'store'])->name('patient.registration.store')->middleware('role:pasien');
    Route::delete('/patient/registration/{id}', [App\Http\Controllers\DaftarPeriksaController::class, 'cancel'])->name('patient.registration.cancel')->middleware('role:pasien');
    Route::get('/patient/check-status', [App\Http\Controllers\DaftarPeriksaController::class, 'checkStatus'])->name('patient.registration.check')->middleware('role:pasien');
    Route::get('/patient', function () {
        return view('patient.dashboard');
    })->name('patient.dashboard')->middleware('role:pasien');
    Route::get('/pharmacist', function () {
        return view('pharmacist.dashboard');
    })->name('pharmacist.dashboard')->middleware('role:apoteker');
    Route::get('/cashier', function () {
        return view('cashier.dashboard');
    })->name('cashier.dashboard')->middleware('role:kasir');

    // Profile Management
    Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'index'])->name('profile.index');
    Route::put('/profile', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
});
