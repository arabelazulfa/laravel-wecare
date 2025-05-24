<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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
        $request->validate([
            'otp' => 'required|digits:6',
        ]);

        $otp = $request->input('otp');

        // TODO: Verifikasi OTP sesuai dengan yang kamu simpan (di session, DB, cache)

        // Contoh: jika OTP valid
        if ($otp == '123456') {  // ganti dengan logika validasi asli
            // Tandai user sudah verifikasi
            // Redirect ke dashboard atau halaman sukses
            return redirect()->route('dashboard')->with('success', 'OTP berhasil diverifikasi!');
        }

        // Jika OTP salah, kembali ke form dengan error
        return back()->withErrors(['otp' => 'Kode OTP salah. Silakan coba lagi.']);
    }
}
