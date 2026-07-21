<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/loket', function () {
    return view('loket');
});

Route::get('/loket_real', function () {
    return view('loket_real');
});