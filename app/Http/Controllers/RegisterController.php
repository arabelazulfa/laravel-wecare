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

    public function storeOrganisasiStep1(Request $request)
    {
        // Validasi input form step 1
        $request->validate([
            'contact_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|string|max:20',
            'password' => 'required|min:6|confirmed',
        ]);

        // Simpan data sementara di session untuk step 2
        session([
            'register_data' => [
                'name' => $request->contact_name,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => bcrypt($request->password), // password sudah hash
                'role' => 'organisasi',
            ],
        ]);

        // Redirect ke halaman form step 2
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

    // Upload logo jika ada
    if ($request->hasFile('logo')) {
        $validated['logo_path'] = $request->file('logo')->store('logos', 'public');
    }

    // Simpan data ke session
    session(['organisasi_detail' => $validated]);

    // Redirect ke preview (step 3)
    return redirect()->route('register.organisasi.preview');
    }

    public function showOrganisasiStep2()
    {
        // Cek apakah data dari step 1 tersedia
        if (!session()->has('register_data')) {
            return redirect()->route('register.organisasi.step1')->with('error', 'Silakan isi data kontak terlebih dahulu.');
        }

        return view('auth.register2_organisasi'); // Pastikan nama path view-nya sesuai
    }
    public function showOrganisasiPreview()
    {   
    // Ambil data dari session
    $step1 = session('register_data');
    $step2 = session('organisasi_detail');

    // Jika salah satu tidak ada, redirect balik
    if (!$step1 || !$step2) {
        return redirect()->route('register.organisasi.step1')->with('error', 'Data tidak lengkap, silakan isi dari awal.');
    }

    // Tampilkan halaman preview
    return view('auth.register3_organisasi', compact('step1', 'step2'));
    }
    public function finalizeOrganisasiRegistration()
    {
    $step1 = session('register_data');
    $step2 = session('organisasi_detail');

    if (!$step1 || !$step2) {
        return redirect()->route('register.organisasi.step1')->with('error', 'Data tidak lengkap.');
    }

    // Simpan user
    $user = User::create([
        'name' => $step1['name'],
        'email' => $step1['email'],
        'password' => $step1['password'],
        'role' => $step1['role'],
        'phone' => $step1['phone'],
    ]);

    // Simpan profile organisasi (pastikan kamu punya model OrganizationProfile)
    OrganizationProfile::create([
        'user_id' => $user->id,
        'nama_organisasi' => $step2['nama_organisasi'],
        'tipe_organisasi' => $step2['tipe_organisasi'],
        'tanggal_berdiri' => $step2['tanggal_berdiri'],
        'lokasi' => $step2['lokasi'],
        'deskripsi_singkat' => $step2['deskripsi_singkat'] ?? null,
        'fokus_utama' => $step2['fokus_utama'] ?? null,
        'alamat' => $step2['alamat'],
        'provinsi' => $step2['provinsi'],
        'kabupaten_kota' => $step2['kabupaten_kota'],
        'kodepos' => $step2['kodepos'],
        'no_telp' => $step2['no_telp'],
        'website' => $step2['website'] ?? null,
        'logo_path' => $step2['logo_path'] ?? null,
    ]);

    // Bersihkan session
    session()->forget(['register_data', 'organisasi_detail']);

    return redirect()->route('otp.form')->with('success', 'Akun organisasi berhasil dibuat. Silakan verifikasi email.');
    }


}