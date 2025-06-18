<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Http\Controllers\{
    AktivitasController,
    CertificateController,
    ChatController,
    DashboardController,
    EventController,
    EventRegistrationController,
    EventReviewController,
    GalleryController,
    LoginController,
    NotificationController,
    OtpController,
    OTPResetController,
    OrganisasiController,
    PresensiController,
    ProfileController,
    RegisterController,
    SertifikasiController,
    UlasanController,
    UserController
};

// ============================
// Public Routes
// ============================

Route::get('/', fn () => view('welcome'));
Route::get('/register', fn () => view('daftar'))->name('register');
Route::get('/login', fn () => view('login'))->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', fn () => Auth::logout() && redirect('/login'))->name('logout');

// ============================
// Volunteer Registration
// ============================

Route::get('/register/volunteer', fn () => view('auth.register_volunteer'))->name('register.volunteer');
Route::post('/register/volunteer', [RegisterController::class, 'storeVolunteer'])->name('store.volunteer');

// ============================
// Organisasi Registration (Multi-step)
// ============================

Route::get('/register/organisasi', fn () => view('auth.register_organisasi'))->name('register.organisasi.step1');
Route::post('/register/organisasi', [RegisterController::class, 'storeOrganisasiStep1'])->name('register.organisasi.step1');
Route::get('/register/organisasi/step2', fn () => view('auth.register2_organisasi'))->name('register.organisasi.step2');
Route::post('/register/organisasi/step2', [RegisterController::class, 'storeOrganisasiDetail'])->name('register.organisasi.detail.store');
Route::get('/register/organisasi/preview', [RegisterController::class, 'showOrganisasiPreview'])->name('register.organisasi.preview');
Route::post('/register/organisasi/finalize', [RegisterController::class, 'finalizeOrganisasiRegistration'])->name('register.organisasi.finalize');
Route::get('/register/organisasi/konfirmasi', [RegisterController::class, 'showKonfirmasi'])->name('register.organisasi.konfirmasi');
Route::post('/register/organisasi/konfirmasi', [RegisterController::class, 'showKonfirmasi'])->name('register.organisasi.konfirmasi');

// ============================
// OTP
// ============================

Route::get('/otp', [OtpController::class, 'showOtpForm'])->name('otp.form');
Route::post('/otp', [OtpController::class, 'verifyOtp'])->name('otp.verify');
Route::post('/otp/resend', [OtpController::class, 'resendOtp'])->name('otp.resend');

// Forgot Password via OTP
Route::get('/forgot-password', [OTPResetController::class, 'showEmailForm'])->name('otp.email');
Route::post('/send-otp', [OTPResetController::class, 'sendOtp'])->name('otp.send');
Route::get('/verify-otp', [OTPResetController::class, 'showVerifyForm'])->name('otp.verify');
Route::post('/verify-otp', [OTPResetController::class, 'verify'])->name('verify.otp');
Route::post('/reset-password', [OTPResetController::class, 'submitNewPassword'])->name('password.reset.submit');

// ============================
// Volunteer Routes (Public)
// ============================

Route::get('/activities', [EventController::class, 'showForVolunteer'])->name('volunteer.events');

// ============================
// Authenticated Routes
// ============================

Route::match(['get', 'post'], '/logout', function () {
    Auth::logout();
    return redirect('/login');
})->name('logout');


Route::middleware('auth')->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboardorg', [DashboardController::class, 'organisasi'])->name('dashboard.organisasi');
    Route::get('/dashboard/profile', [DashboardController::class, 'profile'])->name('dashboard.profile');
    Route::get('/dashboard/edit-profile', [DashboardController::class, 'edit'])->name('dashboard.editprofile');
    Route::post('/dashboard/update-logo', [DashboardController::class, 'updateLogo'])->name('dashboard.updateLogo');

    // Organisasi
    Route::get('/organisasi/{user_id}/edit', [OrganisasiController::class, 'edit'])->name('organisasi.edit');
    Route::put('/organisasi/{user_id}', [OrganisasiController::class, 'update'])->name('organisasi.update');
    Route::post('/organisasi/update-password', [OrganisasiController::class, 'updatePassword'])->name('organisasi.updatePassword');

    // Galeri
    Route::get('/dashboard/galeri', [GalleryController::class, 'index'])->name('dashboard.gallery');
    Route::post('/dashboard/galeri', [GalleryController::class, 'store'])->name('gallery.store');
    Route::delete('/dashboard/galeri/{gallery}', [GalleryController::class, 'destroy'])->name('gallery.destroy');

    // Aktivitas Organisasi
    Route::get('/aktivitas', [AktivitasController::class, 'index'])->name('aktivitas.index');
    Route::get('/aktivitas/tambah', [AktivitasController::class, 'create'])->name('aktivitas.tambah');
    Route::post('/aktivitas/langkah2', [AktivitasController::class, 'keLangkah2'])->name('aktivitas.keLangkah2');
    Route::get('/aktivitas/langkah2', [AktivitasController::class, 'langkah2'])->name('aktivitas.langkah2');
    Route::post('/aktivitas/proses-langkah1', [AktivitasController::class, 'keLangkah2'])->name('aktivitas.keLangkah2'); // duplicate, boleh hapus
    Route::post('/aktivitas/proses-langkah2', [AktivitasController::class, 'keLangkah3'])->name('aktivitas.keLangkah3');
    Route::get('/aktivitas/langkah3', [AktivitasController::class, 'langkah3'])->name('aktivitas.langkah3');
    Route::post('/aktivitas/simpan', [AktivitasController::class, 'simpan'])->name('aktivitas.simpan');
    Route::get('/dashboardorg/aktivitas', [AktivitasController::class, 'index'])->name('aktivitas'); // alias org

    // Event
    Route::resource('events', EventController::class);
    Route::get('/events/{id}/participants', [EventController::class, 'ShowParticipants'])->name('events.participants');
    Route::get('/events/{id}/presensi', [EventController::class, 'presensi'])->name('events.presensi');
    Route::get('/events/{id}', [EventController::class, 'show'])->name('events.show');
    Route::get('/events/{id}/edit', [EventController::class, 'edit'])->name('events.edit');
    Route::put('/aktivitas/{event}', [EventController::class, 'update'])->name('events.update');
    Route::get('/volunteer-events/{id}', [EventController::class, 'showVolunteerDetail'])->name('events.detail.volunteer');
    Route::post('/event-register', [EventRegistrationController::class, 'register'])->name('event.register');

    // Event Registration
    Route::post('/participations/accept', [EventRegistrationController::class, 'accept'])->name('participations.accept');
    Route::resource('event-registrations', EventRegistrationController::class)->only(['create', 'store', 'destroy']);

    // Presensi
    Route::get('/presensi/{event}', [PresensiController::class, 'show'])->name('presensi.show');
    Route::post('/presensi', [PresensiController::class, 'store'])->name('presensi.store');

    // Sertifikasi
    Route::get('/sertifikasi', [SertifikasiController::class, 'index'])->name('sertifikasi.index');
    Route::post('/sertifikat/upload/{id}', [SertifikasiController::class, 'upload'])->name('sertifikat.upload');

    // Review & Ulasan
    Route::post('/ulasan', [UlasanController::class, 'store'])->name('ulasan.store');
    Route::post('/event-reviews', [EventReviewController::class, 'store'])->name('event-reviews.store');

    // Chat (Organisasi & Volunteer)
    Route::get('/chat', [ChatController::class, 'index'])->name('chat.index');
    Route::get('/chat/{id}', [ChatController::class, 'show'])->name('chat.show');
    Route::post('/chat/send', [ChatController::class, 'store'])->name('chat.send');

    Route::get('/volunteer/chat', [ChatController::class, 'volunteerIndex'])->name('volunteer.chat.index');
    Route::get('/volunteer/chat/{id}', [ChatController::class, 'volunteerShow'])->name('volunteer.chat.show');
    Route::post('/volunteer/chat/send', [ChatController::class, 'volunteerSend'])->name('volunteer.chat.send');

    // Volunteer Profile
    Route::get('/volunteer/profile', [ProfileController::class, 'showVolunteer'])->name('volunteer.profile.show');
    Route::post('/volunteer/profile/update-photo', [ProfileController::class, 'updatePhoto'])->name('volunteer.profile.updatePhoto');
    Route::patch('/volunteer/profile/update-field', [ProfileController::class, 'updateField'])->name('volunteer.profile.updateField');
    Route::post('/volunteer/profile/update-password', [ProfileController::class, 'updatePassword'])->name('volunteer.profile.updatePassword');

    // Dashboard untuk relawan
    Route::get('/dashuser', [DashboardController::class, 'index'])->name('dashuser');

    // Notifikasi
    Route::get('/notifications/{id}/read', function ($id) {
        $notification = auth()->user()->notifications()->findOrFail($id);
        $notification->markAsRead();
        return redirect($notification->data['url'] ?? '/');
    })->name('notifications.read');

    // Profil Daftar Peserta
    Route::get('/profildaftar/{id}', [DashboardController::class, 'profildaftar'])->name('profildaftar');
});
