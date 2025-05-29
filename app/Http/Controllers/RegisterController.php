<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\VolunteerProfile;
use App\Models\OrganizationProfile;
use Illuminate\Support\Facades\Hash;
use App\Mail\OtpMail;
use Illuminate\Support\Facades\Mail;

class RegisterController extends Controller
{
    public function storeVolunteer(Request $request)
    {
        // Validasi form termasuk file KTP dan fields volunteer profile
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'phone' => 'required|string',
            'gender' => 'required|in:Laki-Laki,Perempuan',
            'birthdate' => 'required|date',
            'ktp' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'province' => 'required|string',
            'city' => 'required|string',
            'profession' => 'required|string',
            'minat1' => 'required|string',
            'minat2' => 'required|string',
]);


        // Upload KTP
        $ktpPath = $request->file('ktp')->store('ktp_images', 'public');

        // Buat User
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'volunteer',
            'phone' => $request->phone ?? null,
            'gender' => $request->gender ?? null,
            'birthdate' => $request->birthdate ?? null,
            'ktp_path' => $ktpPath,
        ]);

        // Simpan ke volunteer_profiles
        VolunteerProfile::create([
            'user_id' => $user->id,
            'profession' => $request->profession,
            'city' => $request->city,
            'interest1' => $request->interest1,
            'interest2' => $request->interest2,
            'ktp_file' => $ktpPath, // atau sesuai kolom di tabel volunteer_profiles
            // tambahkan fields lain jika ada
        ]);

        // Generate OTP
        $otp = rand(100000, 999999);

        // Simpan session OTP
        session([
            'otp' => $otp,
            'otp_email' => $user->email,
            'otp_expires_at' => now()->addMinutes(5),
        ]);

        Mail::to($request->email)->send(new OtpMail($otp));

        return redirect()->route('otp.form')->with('success', 'Kode OTP telah dikirim ke email Anda.');
    }

    public function storeOrganisasi(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            // Validasi fields untuk organization_profiles:
            'org_name' => 'required|string|max:255',
            'org_type' => 'required|string|max:255',
            'established_date' => 'nullable|date',
            'location' => 'nullable|string|max:255',
            'province' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'postal_code' => 'nullable|string|max:20',
            'org_phone' => 'nullable|string|max:20',
            'website' => 'nullable|url',
            'description' => 'nullable|string',
            'focus_area' => 'nullable|string|max:255',
            // sesuaikan dengan kebutuhan
        ]);

        // Buat User
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'organisasi',
        ]);

        // Simpan ke organization_profiles
        OrganizationProfile::create([
            'user_id' => $user->id,
            'org_name' => $request->org_name,
            'org_type' => $request->org_type,
            'established_date' => $request->established_date,
            'location' => $request->location,
            'province' => $request->province,
            'city' => $request->city,
            'postal_code' => $request->postal_code,
            'org_phone' => $request->org_phone,
            'website' => $request->website,
            'description' => $request->description,
            'focus_area' => $request->focus_area,
            'status' => 'pending', // misal status awal
        ]);

        $otp = rand(100000, 999999);

        session([
            'otp' => $otp,
            'otp_email' => $user->email,
            'otp_expires_at' => now()->addMinutes(5),
        ]);

        Mail::to($request->email)->send(new OtpMail($otp));

        return redirect()->route('otp.form')->with('success', 'Kode OTP telah dikirim ke email Anda.');
    }
}
