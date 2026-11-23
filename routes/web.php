<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KecamatanController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\AdminPelayananController;
use App\Http\Controllers\Auth\MasyarakatAuthController;
use App\Http\Controllers\MasyarakatDashboardController;

// Rute Publik Beranda & Pengaduan Warga
Route::get('/', [KecamatanController::class, 'index'])->name('kecamatan.home');
Route::post('/aspirasi', [KecamatanController::class, 'aspirasi'])->name('kecamatan.aspirasi');

// Rute Autentikasi Masyarakat (Registrasi & Login Warga)
Route::get('/register', [MasyarakatAuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [MasyarakatAuthController::class, 'register'])->name('register.submit');
Route::get('/login', [MasyarakatAuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [MasyarakatAuthController::class, 'login'])->name('login.submit');
Route::post('/logout', [MasyarakatAuthController::class, 'logout'])->name('logout');

// Rute Dashboard Warga / Masyarakat (Terproteksi Auth)
Route::middleware('auth')->prefix('warga')->name('warga.')->group(function () {
    Route::get('/dashboard', [MasyarakatDashboardController::class, 'index'])->name('dashboard');
    Route::post('/layanan', [MasyarakatDashboardController::class, 'storePermohonan'])->name('layanan.store');
    Route::post('/aspirasi', [MasyarakatDashboardController::class, 'storeAspirasi'])->name('aspirasi.store');
    Route::put('/profile', [MasyarakatDashboardController::class, 'updateProfile'])->name('profile.update');
});

// Rute Autentikasi Admin & Pengelolaan Admin
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('login.submit');
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');

    // Rute Terproteksi Auth Admin
    Route::middleware(['auth', 'admin'])->group(function () {
        // Dashboard & Pengaduan Warga
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        Route::patch('/aspirasi/{id}/status', [AdminDashboardController::class, 'updateStatus'])->name('aspirasi.status');
        Route::patch('/aspirasi/{id}/tindak-lanjut', [AdminDashboardController::class, 'tindakLanjut'])->name('aspirasi.tindaklanjut');
        Route::delete('/aspirasi/{id}', [AdminDashboardController::class, 'destroy'])->name('aspirasi.destroy');

        // Pengelolaan Permohonan Pelayanan Publik
        Route::get('/pelayanan', [AdminPelayananController::class, 'index'])->name('pelayanan.index');
        Route::get('/pelayanan/{id}', [AdminPelayananController::class, 'show'])->name('pelayanan.show');
        Route::patch('/pelayanan/{id}/status', [AdminPelayananController::class, 'updateStatus'])->name('pelayanan.status');
        Route::delete('/pelayanan/{id}', [AdminPelayananController::class, 'destroy'])->name('pelayanan.destroy');

        // Manajemen User (CRUD)
        Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
        Route::post('/users', [AdminUserController::class, 'store'])->name('users.store');
        Route::put('/users/{id}', [AdminUserController::class, 'update'])->name('users.update');
        Route::delete('/users/{id}', [AdminUserController::class, 'destroy'])->name('users.destroy');
    });
});
