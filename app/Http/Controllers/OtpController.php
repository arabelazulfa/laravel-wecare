<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\OtpMail;
use App\Models\User;

class OtpController extends Controller
{
    // Tampilkan form OTP
    public function showOtpForm(Request $request)
    {
        $email = $request->query('email');
        $role = $request->query('role');

        if (!$email || !$role) {
            return redirect()->route('register')->with('error', 'Data tidak lengkap.');
        }

        return view('auth.otp', compact('email', 'role'));
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
        $email = $request->input('email');
        $role = $request->input('role');

        if (!$email || !$role) {
            return redirect()->route('register')->with('error', 'Data tidak lengkap, silakan daftar ulang.');
        }

        // Generate OTP baru
        $otp = rand(100000, 999999);

        // Simpan OTP & expire time di session
        session([
            'otp' => $otp,
            'otp_expires_at' => now()->addMinutes(5),
            'otp_email' => $email,
        ]);

        // Kirim email OTP
        Mail::to($email)->send(new OtpMail($otp));

        // Redirect kembali ke halaman OTP dengan parameter email & role
        return redirect()->route('otp.form', ['email' => $email, 'role' => $role])
            ->with('success', 'Kode OTP baru telah dikirim ke email kamu.');
    }


}
