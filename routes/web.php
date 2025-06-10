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
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/register', function () {
    return view('daftar');  
})->name('register');

Route::get('/login', function () {
    return view('login');
})->name('login');
Route::post('/login', [LoginController::class, 'login']);

Route::get('/register/volunteer', function () {
    return view('auth.register_volunteer'); 
})->name('register.volunteer');
 
Route::post('/register/volunteer', [RegisterController::class, 'storeVolunteer'])->name('store.volunteer');

// Form registrasi organisasi step 1 (GET)
Route::get('/register/organisasi', function () {
    return view('auth.register_organisasi');
})->name('register.organisasi.step1');

Route::post('/register/organisasi', [RegisterController::class, 'storeOrganisasiStep1'])->name('register.organisasi.step1');
//Route::post('/register/organization/step1', [RegisterController::class, 'goToStep2'])->name('register.organization.step1');

// Form registrasi organisasi step 2 (GET)
Route::get('/register/organisasi/step2', function () {
    return view('auth.register2_organisasi');
})->name('register.organisasi.step2');

//Route::get('/register/organisasi/step2', [RegisterController::class, 'showOrganisasiStep2'])->name('register.organisasi.step2');
Route::post('/register/organisasi/step2', [RegisterController::class, 'storeOrganisasiDetail'])->name('register.organisasi.detail.store');

// Step 3: Preview Data
Route::get('/register/organisasi/preview', [RegisterController::class, 'showOrganisasiPreview'])->name('register.organisasi.preview');

Route::post('/register/organisasi/finalize', [RegisterController::class, 'finalizeOrganisasiRegistration'])
    ->name('register.organisasi.finalize');


Route::get('/register/organisasi/konfirmasi', [RegisterController::class, 'showKonfirmasi'])
    ->name('register.organisasi.konfirmasi');
Route::post('/register/organisasi/konfirmasi', [RegisterController::class, 'showKonfirmasi'])
    ->name('register.organisasi.konfirmasi');

//route OTP
Route::get('/otp', [OtpController::class, 'showOtpForm'])->name('otp.form');
Route::post('/otp', [OtpController::class, 'verifyOtp'])->name('otp.verify');
Route::post('/otp/resend', [OtpController::class, 'resendOtp'])->name('otp.resend');

Route::get('/activities', [EventController::class, 'showForVolunteer'])->name('volunteer.events');

Route::post('/logout', function () {
    Auth::logout();
    return redirect('/login');
})->name('logout');

Route::get('/aktivitas', function () {
    return view('auth.aktivitas_organisasi1');
});


// auth-protected pages
Route::middleware('auth')->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    // Dashboard untuk organisasi
    Route::get('/dashboardorg', [DashboardController::class, 'organisasi'])
        ->name('dashboard.organisasi');

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

    // Route::get('/volunteer/events', [EventController::class, 'showForVolunteer'])->name('volunteer.events');
});

