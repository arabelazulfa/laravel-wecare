<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Mail\OtpMail;
use Illuminate\Support\Facades\Mail;

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
            'otp_expires_at' => now()->addMinutes(5), // Set OTP expired dalam 10 menit
        ]);

        Mail::to($request->email)->send(new OtpMail($otp));

        // Redirect ke halaman OTP
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

        // Simpan data, upload logo jika ada, dll.
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

}