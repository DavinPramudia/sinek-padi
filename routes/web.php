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


Route::middleware(['auth'])->group(function () {
        
    Route::middleware(['petugas'])->group(function () {
        Route::get('/petugas/loket', [LoketController::class, 'index'])->name('petugas.loket');
        Route::post('/transaksi/store', [LoketController::class, 'store'])->name('transaksi.store');
        Route::get('/transaksi/cetak/{id}', [LoketController::class, 'cetak'])->name('transaksi.cetak');
    });


    Route::middleware(['admin'])->group(function () {
        
        // Halaman Admin Dashboard
        Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
        Route::get('/admin/dashboard/export-excel', [DashboardController::class, 'exportExcel'])->name('admin.dashboard.export');
        
        // Halaman Laporan Transaksi Admin
        Route::get('/admin/laporan-transaksi', [LaporanController::class, 'index'])->name('admin.laporan-transaksi');
        Route::get('/admin/laporan-transaksi/export-excel', [LaporanController::class, 'exportExcel'])->name('admin.laporan.export');

        // Halaman Manajemen Akun
        Route::get('/admin/manajemen-akun', [AdminController::class, 'manajemenAkun'])->name('admin.manajemen-akun');
        Route::get('/admin/manajemen-akun/tambah', [AdminController::class, 'create'])->name('admin.manajemen-akun.tambah');
        Route::post('/admin/manajemen-akun/store', [AdminController::class, 'store'])->name('admin.manajemen-akun.store');
        Route::get('/admin/manajemen-akun/edit/{id}', [AdminController::class, 'edit'])->name('admin.manajemen-akun.edit');
        Route::put('/admin/manajemen-akun/update/{id}', [AdminController::class, 'update'])->name('admin.manajemen-akun.update');
        Route::delete('/admin/manajemen-akun/delete/{id}', [AdminController::class, 'destroy'])->name('admin.manajemen-akun.destroy');

        // Halaman Pengaturan Admin
        Route::get('/admin/pengaturan', [PengaturanController::class, 'index'])->name('admin.pengaturan');
        Route::put('/admin/pengaturan/{id}', [PengaturanController::class, 'update'])->name('admin.pengaturan.update');
    });


    Route::get('/profile', [AdminController::class, 'profileEdit'])->name('profile.edit');
    Route::put('/profile/update', [AdminController::class, 'profileUpdate'])->name('profile.update');
});