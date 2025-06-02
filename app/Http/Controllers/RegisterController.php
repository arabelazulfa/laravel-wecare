<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Mail\OtpMail;
use Illuminate\Support\Facades\Mail;
use App\Models\OrganizationProfile;

class RegisterController extends Controller
{
    public function storeVolunteer(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'ktp' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $ktpPath = $request->file('ktp')->store('ktp_images', 'public');

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'volunteer',
            'phone' => $request->phone,
            'gender' => $request->gender,
            'birthdate' => $request->birthdate,
            'ktp_path' => $ktpPath,
        ]);

        $otp = rand(100000, 999999);

        session([
            'otp' => $otp,
            'otp_email' => $user->email,
            'otp_expires_at' => now()->addMinutes(5),
        ]);

        Mail::to($user->email)->send(new OtpMail($otp));

        return redirect()->route('otp.form')
            ->with('success', 'Kode OTP telah dikirim ke email Anda.')
            ->with('role', 'volunteer');
    }

    public function storeOrganisasiStep1(Request $request)
    {
        $request->validate([
            'contact_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|string|max:20',
            'password' => 'required|min:6|confirmed',
        ]);

        session([
            'register_data' => [
                'name' => $request->contact_name,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => Hash::make($request->password), // lebih baik pakai Hash::make
                'role' => 'organizer', // gunakan 'organizer' sesuai enum di DB
            ],
        ]);

        return redirect()->route('register.organisasi.step2');
    }

    public function storeOrganisasiDetail(Request $request)
    {
        $validated = $request->validate([
            'nama_organisasi' => 'required|string|max:255',
            'tipe_organisasi' => 'required|string',
            'tanggal_berdiri' => 'required|date',
            'lokasi' => 'required|string',
            'deskripsi_singkat' => 'nullable|string',
            'fokus_utama' => 'nullable|string',
            'alamat' => 'required|string',
            'provinsi' => 'required|string',
            'kabupaten_kota' => 'required|string',
            'kodepos' => 'required|string',
            'no_telp' => 'required|string',
            'website' => 'nullable|url',
            'logo' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('logos', 'public');
            $validated['logo_path'] = $logoPath;
        }

        unset($validated['logo']); // hapus file upload objek

        session(['organisasi_detail' => $validated]);

        // Langsung ke preview, OTP dikirim di finalize step
        return redirect()->route('register.organisasi.preview');
    }

    public function showOrganisasiStep2()
    {
        if (!session()->has('register_data')) {
            return redirect()->route('register.organisasi.step1')->with('error', 'Silakan isi data kontak terlebih dahulu.');
        }

        return view('auth.register2_organisasi');
    }

    public function showOrganisasiPreview()
    {
        $step1 = session('register_data');
        $step2 = session('organisasi_detail');

        if (!$step1 || !$step2) {
            return redirect()->route('register.organisasi.step1')->with('error', 'Data tidak lengkap, silakan isi dari awal.');
        }

        return view('auth.register3_organisasi', compact('step1', 'step2'));
    }

    public function finalizeOrganisasiRegistration()
    {
        $step1 = session('register_data');
        $step2 = session('organisasi_detail');

        if (!$step1 || !$step2) {
            return redirect()->route('register.organisasi.step1')->with('error', 'Data tidak lengkap.');
        }

        $user = User::create([
            'name' => $step1['name'],
            'email' => $step1['email'],
            'password' => $step1['password'],
            'role' => 'organizer', // pastikan ini sesuai enum
            'phone' => $step1['phone'],
        ]);

        OrganizationProfile::create([
            'user_id' => $user->id,
            'org_name' => $step2['nama_organisasi'],
            'org_type' => $step2['tipe_organisasi'],
            'established_date' => $step2['tanggal_berdiri'],
            'location' => $step2['lokasi'],
            'description' => $step2['deskripsi_singkat'] ?? null,
            'focus_area' => $step2['fokus_utama'] ?? null,
            'province' => $step2['provinsi'],
            'city' => $step2['kabupaten_kota'],
            'postal_code' => $step2['kodepos'],
            'org_phone' => $step2['no_telp'],
            'website' => $step2['website'] ?? null,
            'logo' => $step2['logo_path'] ?? null,

        ]);


        session()->forget(['register_data', 'organisasi_detail']);

        $otp = rand(100000, 999999);

        session([
            'otp' => $otp,
            'otp_email' => $user->email,
            'otp_expires_at' => now()->addMinutes(5),
        ]);

        Mail::to($user->email)->send(new OtpMail($otp));

        return redirect()->route('otp.form', ['role' => 'organizer', 'email' => $user->email])
            ->with('success', 'Kode OTP telah dikirim ke email Anda.');
    }

    public function showKonfirmasi(Request $request)
    {
        return view('auth.otp', ['role' => 'organizer']);
    }
}
