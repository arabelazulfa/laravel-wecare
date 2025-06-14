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
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AktivitasController;
use App\Http\Controllers\SertifikasiController;
use App\Http\Controllers\OrganisasiController;
use App\Models\OrganizationProfile;

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


// Route::get('/aktivitas', function () {
//     return view('auth.aktivitas_organisasi1');
// });

Route::get('/aktivitas/tambah', function () {
    return view('auth.aktivitas_organisasi2');
})->name('aktivitas.tambah');

// Route::get('/aktivitas/tambah/lanjut', function () {
//     return view('auth.aktivitas_organisasi3');
// })->name('aktivitas.langkah2');

// Langkah 1: Form awal
Route::get('/aktivitas/tambah', [AktivitasController::class, 'create'])->name('aktivitas.tambah');

// Proses langkah 1 ke langkah 2
Route::post('/aktivitas/proses-langkah1', [AktivitasController::class, 'keLangkah2'])->name('aktivitas.keLangkah2');

// Langkah 2: Form divisi/tugas
Route::get('/aktivitas/langkah2', [AktivitasController::class, 'langkah2'])->name('aktivitas.langkah2');

// Proses langkah 2 ke langkah 3
Route::post('/aktivitas/proses-langkah2', [AktivitasController::class, 'keLangkah3'])->name('aktivitas.keLangkah3');

// Langkah 3: Konfirmasi/simpan
Route::get('/aktivitas/langkah3', [AktivitasController::class, 'langkah3'])->name('aktivitas.langkah3');
Route::post('/aktivitas/simpan', [AktivitasController::class, 'simpan'])->name('aktivitas.simpan');

Route::get('/aktivitas', [AktivitasController::class, 'daftarAktivitas'])->name('dashboardorg');

Route::middleware(['auth'])->group(function () {
    // Daftar aktivitas
    Route::get('/aktivitas', [AktivitasController::class, 'index'])->name('aktivitas.index');

    // Langkah 1: Form awal
    Route::get('/aktivitas/tambah', [AktivitasController::class, 'create'])->name('aktivitas.tambah');

    // Proses langkah 1 → simpan ke session & redirect ke langkah 2
    Route::post('/aktivitas/langkah2', [AktivitasController::class, 'keLangkah2'])->name('aktivitas.keLangkah2');

    // Langkah 2: Form detail tugas relawan
    Route::get('/aktivitas/langkah2', [AktivitasController::class, 'langkah2'])->name('aktivitas.langkah2');

    // Proses final: Simpan ke database
    Route::post('/aktivitas/simpan', [AktivitasController::class, 'simpan'])->name('aktivitas.simpan');
});
Route::get('/events/{id}', [EventController::class, 'show'])->name('events.show');
Route::get('/events/{id}/participants', [EventController::class, 'participants'])->name('events.participants');
Route::get('/events/{id}/presentation', [EventController::class, 'presentation'])->name('events.presentation');

// auth-protected pages
Route::middleware('auth')->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    // Dashboard untuk organisasi
    Route::get('/dashboardorg', [DashboardController::class, 'organisasi'])
        ->name('dashboard.organisasi');
    Route::get('/dashboard/profile', [DashboardController::class, 'profile'])
        ->name('dashboard.profile');
    Route::get('/dashboard/edit-profile', [DashboardController::class, 'edit'])
        ->name('dashboard.editprofile');
    Route::get('/aktivitas', [AktivitasController::class, 'index'])
        ->name('aktivitas.index');
    Route::get('/aktivitas/tambah', [AktivitasController::class, 'create'])
        ->name('aktivitas.tambah');
    Route::get('/sertifikasi', [SertifikasiController::class, 'index'])
        ->name('sertifikasi.index');
    Route::post('/sertifikat/upload/{id}', [SertifikasiController::class, 'upload'])->name('sertifikat.upload');

    Route::get('/organisasi/{user_id}/edit', [OrganisasiController::class, 'edit'])
        ->name('organisasi.edit');
    Route::put('/organisasi/{user_id}', [OrganisasiController::class, 'update'])
        ->name('organisasi.update');


    // Events CRUD (HTML pages & forms)
    Route::resource('events', EventController::class);

    // Registrasi volunteer ke event (jika pakai form web)
    Route::resource('event-registrations', EventRegistrationController::class)
        ->only(['create', 'store', 'destroy']);     // sesuaikan kebutuhan

    // Sertifikat (download / view)
    Route::resource('certificates', CertificateController::class)
        ->only(['index', 'show']);

    // Notifikasi (tampilkan halaman daftar notifikasi)
    // Route::resource('notifications', NotificationController::class)
    //     ->only(['index']);

    // Kelola profil user (admin / user sendiri)
    Route::resource('users', UserController::class)
        ->except(['create', 'store']);  // biasanya daftar lewat /register

    // Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    // Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    // Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');

    Route::get('/notifications/{id}/read',
    action: [NotificationController::class, 'markAsRead'])
    ->name('notifications.read');


    Route::get('/dashboardorg/aktivitas',
    [AktivitasController::class, 'index'])
    ->name('aktivitas');


    // Route::get('/volunteer/events', [EventController::class, 'showForVolunteer'])->name('volunteer.events');
});

