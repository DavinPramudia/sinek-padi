<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.process');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Rute yang dikunci (Tidak bisa ditembak URL-nya kalau belum login)
Route::middleware(['auth'])->group(function () {
    Route::get('/petugas/loket', function () {
        return view('petugas.loket');
    });
});