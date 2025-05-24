<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function storeVolunteer(Request $request)
    {
        // Validasi form termasuk file KTP
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'ktp' => 'required|image|mimes:jpeg,png,jpg|max:2048', // validasi file KTP
        ]);

        // Upload KTP ke storage/app/public/ktp_images
        $ktpPath = $request->file('ktp')->store('ktp_images', 'public');

        // Simpan user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'volunteer',
            'ktp_path' => $ktpPath, // Simpan path file KTP
        ]);

        // Generate OTP 6 digit
        $otp = rand(100000, 999999);

        // Simpan OTP dan email ke session
        session([
            'otp' => $otp,
            'otp_email' => $user->email,
        ]);

        // (Opsional) Kirim OTP ke email di sini

        // Redirect ke halaman OTP
        return redirect()->route('otp.form')->with('success', 'Kode OTP telah dikirim ke email Anda.');
    }

    public function storeOrganisasi(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'organisasi',
        ]);

        $otp = rand(100000, 999999);
        session([
            'otp' => $otp,
            'otp_email' => $user->email,
        ]);

        return redirect()->route('otp.form')->with('success', 'Kode OTP telah dikirim ke email Anda.');
    }
}
