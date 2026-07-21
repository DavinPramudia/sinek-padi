<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/petugas/loket', function () {
    return view('petugas.loket');
});

Route::get('/petugas/loket_real', function () {
    return view('petugas.loket_real');
});