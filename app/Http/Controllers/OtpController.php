<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\OtpMail;

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

    if (!$sessionOtp || now()->gt($expiresAt)) {
        return back()->withErrors(['otp' => 'Kode OTP sudah kadaluarsa. Silakan minta kode baru.']);
    }

    if ($inputOtp == $sessionOtp) {
        // Tandai user sudah verifikasi, misal update DB user
        // Hapus session otp supaya gak bisa dipakai lagi
        session()->forget(['otp', 'otp_expires_at', 'user_email']);
            return view('auth.otp_success');
        }

        // Jika OTP salah, kembali ke form dengan error
        return back()->withErrors(['otp' => 'Kode OTP salah. Silakan coba lagi.']);
    }
    // Fitur kirim ulang OTP
    public function resendOtp(Request $request)
    {
        $userEmail = session('user_email'); // Pastikan email disimpan di session saat register

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
