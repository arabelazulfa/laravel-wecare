<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\EventRegistrationController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\OtpController;


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

// Halaman form register volunteer & organisasi
Route::get('/register/volunteer', function () {
    return view('auth.register_volunteer');
});

Route::get('/register/organisasi', function () {
    return view('auth.register_organisasi');
});

// Proses simpan data pendaftaran
Route::post('/register/volunteer', [RegisterController::class, 'storeVolunteer'])->name('register.volunteer');
Route::post('/register/organisasi', [RegisterController::class, 'storeOrganisasi'])->name('register.organisasi');

//route OTP
Route::get('/otp', [OtpController::class, 'showOtpForm'])->name('otp.form');
Route::post('/otp', [OtpController::class, 'verifyOtp'])->name('otp.verify');

Route::get('/login', function () {
    return view('login');
})->name('login');



