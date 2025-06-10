<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\OrganizationProfile;
use App\Models\EventReview;
use App\Models\User;

class ProfileController extends Controller
{
    // Tampilkan halaman profil
    public function show()
{
    $user = auth()->user();
    $profile = OrganizationProfile::where('user_id', $user->id)->first();
    $reviews = EventReview::where('event_id', function ($query) use ($user) {
        $query->select('id')
              ->from('events')
              ->where('organizer_id', $user->id);
    })->with('user')->latest()->take(3)->get();

    return view('dashboard.profile', compact('profile', 'reviews'));
}
    // Tampilkan form edit profil
    public function edit()
    {
        $user = Auth::user();
        return view('dashboard.editprofile', compact('user'));
    }

    // Simpan perubahan profil
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|min:8|confirmed',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;

        // Kalau ada perubahan password
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('profile.show')->with('success', 'Profil berhasil diperbarui.');
    }
}
