<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\OtpMail;
use App\Models\User;
use App\Notifications\VolunteerRegistered;

class OtpController extends Controller
{
    // Tampilkan form OTP
    public function showOtpForm()
    {
        return view('auth.otp');
    }

    // Proses verifikasi OTP
    public function verifyOtp(Request $request)
{
    $request->validate(['otp' => 'required|digits:6']);

    $inputOtp = $request->otp;
    $sessionOtp = session('otp');
    $expiresAt = session('otp_expires_at');
    $email = session('otp_email');

    if (!$sessionOtp || now()->gt($expiresAt)) {
        return back()->withErrors(['otp' => 'Kode OTP sudah kadaluarsa. Silakan minta kode baru.']);
    }

    if ($inputOtp == $sessionOtp) {
        // Cari user berdasarkan email
        $user = User::where('email', $email)->first();

        if ($user) {
            // Tambahkan update info jika ada input lanjut (jika tidak dari form, bisa diabaikan)
            $user->email_verified_at = now(); // contoh penanda user sudah verifikasi
            $user->save();

            // Kirim notifikasi kalau dia ORGANIZER
            if ($user->role === 'organizer') {
                $user->notify(new \App\Notifications\OrganizationRegistered());
        }

        // Kirim notifikasi kalau dia VOLUNTEER
            if ($user->role === 'volunteer') {
                $user->notify(new VolunteerRegistered());
        }
        }

        // Hapus session otp
        session()->forget(['otp', 'otp_expires_at', 'otp_email']);

        return view('auth.otp_success');
    }

    return back()->withErrors(['otp' => 'Kode OTP salah. Silakan coba lagi.']);
}
    // Fitur kirim ulang OTP
    public function resendOtp(Request $request)
    {
        $userEmail = session('otp_email'); // Pastikan email disimpan di session saat register

        if (!$userEmail) {
            return redirect()->route('register')->with('error', 'Email tidak ditemukan, silakan daftar ulang.');
        }

        // Generate OTP baru
        $otp = rand(100000, 999999);

        // Simpan OTP & expire time di session
        session(['otp' => $otp, 'otp_expires_at' => now()->addMinutes(5)]);

        // Kirim email OTP
        Mail::to($userEmail)->send(new OtpMail($otp));

        return back()->with('success', 'Kode OTP baru telah dikirim ke email kamu.');
    }

}
