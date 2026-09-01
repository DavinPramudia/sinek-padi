<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LoketController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DashboardController; 
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\PengaturanController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:5,1')->name('login.process');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Route khusus yang harus login dulu (Middleware Auth)
Route::middleware(['auth'])->group(function () {
        
    // 1. Halaman Petugas Loket
    Route::get('/petugas/loket', [LoketController::class, 'index'])->name('petugas.loket');

    // 2. Halaman Admin Dashboard (Diubah menggunakan DashboardController)
    Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/dashboard/export-excel', [DashboardController::class, 'exportExcel'])->name('admin.dashboard.export');

    // 3. Route untuk menyimpan transaksi
    Route::post('/transaksi/store', [LoketController::class, 'store'])->name('transaksi.store');

    // 4. Route untuk cetak karcis
    Route::get('/transaksi/cetak/{id}', [LoketController::class, 'cetak'])->name('transaksi.cetak');

    // Route::get('/transaksi/qrcode/{id}', [LoketController::class, 'qrcode'])->name('transaksi.qrcode');
    
    // 5. Halaman Laporan Transaksi Admin
    Route::get('/admin/laporan-transaksi', [LaporanController::class, 'index'])->name('admin.laporan-transaksi');
    Route::get('/admin/laporan-transaksi/export-excel', [LaporanController::class, 'exportExcel'])->name('admin.laporan.export');

    // 6. Halaman Manajemen Akun (DIHUBUNGKAN KE AdminController)
    Route::get('/admin/manajemen-akun', [AdminController::class, 'manajemenAkun'])->name('admin.manajemen-akun');

    // Rute Tambah Akun
    Route::get('/admin/manajemen-akun/tambah', [AdminController::class, 'create'])->name('admin.manajemen-akun.tambah');
    Route::post('/admin/manajemen-akun/store', [AdminController::class, 'store'])->name('admin.manajemen-akun.store');

    // Rute Edit Akun
    Route::get('/admin/manajemen-akun/edit/{id}', [AdminController::class, 'edit'])->name('admin.manajemen-akun.edit');
    Route::put('/admin/manajemen-akun/update/{id}', [AdminController::class, 'update'])->name('admin.manajemen-akun.update');

    // Rute Hapus Akun
    Route::delete('/admin/manajemen-akun/delete/{id}', [AdminController::class, 'destroy'])->name('admin.manajemen-akun.destroy');

    // 7. Halaman Pengaturan Admin
    Route::get('/admin/pengaturan', [PengaturanController::class, 'index'])->name('admin.pengaturan');
    Route::put('/admin/pengaturan/{id}', [PengaturanController::class, 'update'])->name('admin.pengaturan.update');

    // 8. Halaman Profil & Ganti Password (Dihandle oleh AdminController)
    Route::get('/profile', [AdminController::class, 'profileEdit'])->name('profile.edit');
    Route::put('/profile/update', [AdminController::class, 'profileUpdate'])->name('profile.update');
});