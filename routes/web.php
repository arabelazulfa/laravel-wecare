<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\EventRegistrationController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('welcome');
});
Route::view('/register', 'daftar');
Route::view('/login', 'login')->name('login');

// auth-protected pages
Route::middleware('auth')->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    // Events CRUD (HTML pages & forms)
    Route::resource('events', EventController::class);

    // Registrasi volunteer ke event (jika pakai form web)
    Route::resource('event-registrations', EventRegistrationController::class)
        ->only(['create', 'store', 'destroy']);     // sesuaikan kebutuhan

    // Sertifikat (download / view)
    Route::resource('certificates', CertificateController::class)
        ->only(['index', 'show']);

    // Notifikasi (tampilkan halaman daftar notifikasi)
    Route::resource('notifications', NotificationController::class)
        ->only(['index']);

    // Kelola profil user (admin / user sendiri)
    Route::resource('users', UserController::class)
        ->except(['create', 'store']);  // biasanya daftar lewat /register

    Route::get('/notifications/{id}/read',
    [NotificationController::class, 'markAsRead'])
    ->name('notifications.read');

});

Route::get('/', function () {
    return view('welcome');
});
Route::get('/register', function () {
    return view('daftar');  
});
Route::get('/login', function () {
    return view('login');
})->name('login');



