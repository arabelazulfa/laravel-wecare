<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\OtpResetMail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Carbon\Carbon;

class OTPResetController extends Controller
{
    public function showEmailForm()
    {
        return view('auth.otp_email');
    }

    public function sendOtp(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:users,email']);

        $otp = rand(100000, 999999);
        $expiresAt = Carbon::now()->addMinutes(10);

        DB::table('users')
            ->where('email', $request->email)
            ->update([
                'otp_code' => $otp,
                'otp_expires_at' => $expiresAt,
            ]);

        Mail::to($request->email)->send(new OtpResetMail($otp));

        Session::put('email', $request->email);

        return redirect()->route('otp.verify.reset')->with('status', 'Kode OTP telah dikirim ke email Anda');
    }

    public function showVerifyForm()
    {
        return view('auth.otp_verify');
    }

    public function verify(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp_code' => 'required'
        ]);

        $user = User::where('email', $request->email)
                    ->where('otp_code', $request->otp_code)
                    ->where('otp_expires_at', '>', Carbon::now())
                    ->first();

        if (!$user) {
            return back()->withErrors(['otp_code' => 'Kode OTP salah atau sudah kedaluwarsa.']);
        }

        Session::put('reset_email', $request->email);
        return view('auth.reset_password');
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
        $user->otp_code = null;
        $user->otp_expires_at = null;
        $user->save();

        Session::forget('reset_email');
        Session::forget('email');

        return redirect()->route('login')->with('status', 'Password berhasil diubah. Silakan login.');
    }
}