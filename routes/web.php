<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LoketController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.process');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Route khusus yang harus login dulu (Middleware Auth)
Route::middleware(['auth'])->group(function () {
    
    // 1. Halaman Petugas Loket
    Route::get('/petugas/loket', [LoketController::class, 'index'])->name('petugas.loket');

    // 2. Halaman Admin
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    });

    // 3. Route untuk menyimpan transaksi
    Route::post('/transaksi/store', [LoketController::class, 'store'])->name('transaksi.store');

    // 4. Route untuk cetak karcis
    Route::get('/transaksi/cetak/{id}', [LoketController::class, 'cetak'])->name('transaksi.cetak');
    
});