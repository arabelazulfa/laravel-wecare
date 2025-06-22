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
    
    public function showOtpForm()
    {
        return view('auth.otp');
    }

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
        
        $user = User::where('email', $email)->first();

        if ($user) {

            $user->email_verified_at = now(); 
            $user->save();

          
            if ($user->role === 'organizer') {
                $user->notify(new \App\Notifications\OrganizationRegistered());
        }

        
            if ($user->role === 'volunteer') {
                $user->notify(new VolunteerRegistered());
        }
        }

  
        session()->forget(['otp', 'otp_expires_at', 'otp_email']);

        return view('auth.otp_success');
    }

    return back()->withErrors(['otp' => 'Kode OTP salah. Silakan coba lagi.']);
}
   
    public function resendOtp(Request $request)
    {
        $userEmail = session('otp_email'); 

        if (!$userEmail) {
            return redirect()->route('register')->with('error', 'Email tidak ditemukan, silakan daftar ulang.');
        }

      
        $otp = rand(100000, 999999);

  
        session(['otp' => $otp, 'otp_expires_at' => now()->addMinutes(5)]);

        
        Mail::to($userEmail)->send(new OtpMail($otp));

        return back()->with('success', 'Kode OTP baru telah dikirim ke email kamu.');
    }

}
