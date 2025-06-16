<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\OTPResetMail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Str;
use Carbon\Carbon;

class OTPResetController extends Controller
{
    public function showEmailForm()
    {
        return view('auth.otp_email');
    }

    public function sendOtp(Request $request)
{
    $request->validate(['email' => 'required|email']);

    $otp = rand(100000, 999999); // generate 6 digit OTP
    $expiresAt = Carbon::now()->addMinutes(10);

    // Simpan ke users table (atau table OTP-mu)
    DB::table('users')
        ->where('email', $request->email)
        ->update([
            'otp_code' => $otp,
            'otp_expires_at' => $expiresAt,
        ]);

    // Kirim email (pastikan mail config benar)
    Mail::to($request->email)->send(new OTPResetMail($otp));

    // Simpan email & otp ke session
    Session::put('otp_code', $otp);
    Session::put('email', $request->email);

    return redirect()->route('otp.verify')->with('success', 'Kode OTP telah dikirim ke email Anda');
    }

    public function showVerifyForm()
    {
        return view('auth.otp_verify');
    }

    public function verify(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'otp_code' => 'required',
    ]);

    $email = $request->input('email');
    $otp = $request->input('otp_code');

    // Misalnya OTP disimpan di session (atau bisa juga di database)
    $sessionOtp = session('otp_code');

    if ($otp != $sessionOtp) {
        return back()->withErrors(['otp_code' => 'Kode OTP salah.']);
    }

    // OTP cocok, arahkan ke reset_password.blade.php
    return view('auth.reset_password', ['email' => $email]);
}



    public function showResetForm(Request $request)
{
    $request->validate([
        'email' => 'required|email|exists:users,email',
        'otp' => 'required',
    ]);

    // (verifikasi OTP dulu, jika perlu)

    return view('auth.otp_reset', [
        'email' => $request->email,
    ]);
}


    public function resetPassword(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'password' => 'required|confirmed|min:6',
    ]);

    $user = User::where('email', $request->email)->first();

    if ($user) {
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect('/login')->with('status', 'Password berhasil direset.');
    }

    return back()->withErrors(['email' => 'Email tidak ditemukan.']);
}
    public function submitNewPassword(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'password' => 'required|min:6|confirmed',
    ]);

    $user = User::where('email', $request->email)->first();

    if (!$user) {
        return back()->withErrors(['email' => 'Email tidak ditemukan']);
    }

    $user->password = Hash::make($request->password);
    $user->save();

    // Hapus token OTP (opsional)
    DB::table('password_reset_tokens')->where('email', $request->email)->delete();

    return redirect()->route('login')->with('status', 'Password berhasil diubah. Silakan login.');
}
    public function showOtpForm(Request $request)
{
    return view('auth.otp_verify', ['email' => $request->email]);
}


}
