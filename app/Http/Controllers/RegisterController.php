<?php
 
namespace App\Http\Controllers;

use App\Models\User;
use App\Models\VolunteerProfile;
use App\Models\OrganizationProfile;
use App\Mail\OtpMail;
use App\Notifications\OrganizationRegistered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class RegisterController extends Controller
{
    public function storeVolunteer(Request $request)
    {
        $validInterests = ['Kemanusiaan', 'Kesehatan', 'Pendidikan', 'Kepemimpinan', 'Ketenagakerjaan', 'Lingkungan', 'Bencana Alam'];
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'ktp' => 'required|image|mimes:jpeg,png,jpg|max:2048',

            // field tambahan
            'phone'         => 'required|string|max:20',
            'gender'        => 'required|string|in:Laki-Laki,Perempuan',
            'birthdate'     => 'required|date',
            'minat1'     => 'required|string|in:' . implode(',', $validInterests),
            'minat2'     => 'required|string|in:' . implode(',', $validInterests),
            'city'          => 'nullable|string|max:255',
            'profession'    => 'nullable|string|max:255',
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

        VolunteerProfile::create([
            'user_id'    => $user->id,
            'interest1'  => $request->minat1,
            'interest2'  => $request->minat2,
            'city'       => $request->city,      // kalau kolom-nya city
            'profession' => $request->profession,
            'ktp_file'   => $ktpPath,
            // simpan field lain kalau ada
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
        'org_name' => 'required|string|max:255',
        'org_type' => 'required|string',
        'established_date' => 'required|date',
        'location' => 'required|string',
        'description' => 'nullable|string',
        'focus_area' => 'nullable|string',
        'province' => 'required|string',
        'city' => 'required|string',
        'postal_code' => 'required|string',
        'org_phone' => 'required|string',
        'website' => 'nullable|url',
        'logo' => 'nullable|image|max:2048',
    ]);

    if ($request->hasFile('logo')) {
        $logoPath = $request->file('logo')->store('logos', 'public');
        $validated['logo'] = $logoPath;
    }

    // JANGAN UNSET logo
    session(['organisasi_detail' => $validated]);

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
            'org_name' => $step2['org_name'],
            'org_type' => $step2['org_type'],
            'established_date' => $step2['established_date'],
            'location' => $step2['location'],
            'description' => $step2['description'] ?? null,
            'focus_area' => $step2['focus_area'] ?? null,
            'province' => $step2['province'],
            'city' => $step2['city'],
            'postal_code' => $step2['postal_code'],
            'org_phone' => $step2['org_phone'],
            'website' => $step2['website'] ?? null,
            'logo' => $step2['logo'] ?? null,

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
