<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.process');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Route khusus yang harus login dulu (Middleware Auth)
Route::middleware(['auth'])->group(function () {
    
    // Halaman Petugas
    Route::get('/petugas/loket', function () {
        return view('petugas.loket');
    });

    // Halaman Admin (Pastikan file view/controller ini ada nanti)
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    });
});