<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/petugas/loket', function () {
    return view('petugas.loket');
});

Route::get('/login', function() {
    return view('login');
});