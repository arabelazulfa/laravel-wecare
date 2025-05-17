<?php

use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});
Route::get('/register', function () {
    return view('daftar');  
});
Route::get('/login', function () {
    return view('login');
})->name('login');

