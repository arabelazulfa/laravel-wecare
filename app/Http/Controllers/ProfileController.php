<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\OrganizationProfile;
use App\Models\VolunteerProfile;
use App\Models\EventReview;
use App\Models\User;

class ProfileController extends Controller
{
    
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
 
    public function edit()
    {
        $user = Auth::user();
        return view('dashboard.editprofile', compact('user'));
    }


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

        
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('profile.show')->with('success', 'Profil berhasil diperbarui.');
    }

   
    public function showVolunteer()
    {
        $user = Auth::user();
        $volProfile = VolunteerProfile::where('user_id', $user->id)->first();

        $validInterests = [
            'Kemanusiaan',
            'Kesehatan',
            'Pendidikan',
            'Kepemimpinan',
            'Ketenagakerjaan',
            'Lingkungan',
            'Bencana Alam'
        ];

        return view('profilevol', compact('user', 'volProfile', 'validInterests'));
    }

    public function updateField(Request $request)
    {
       
        $request->validate([
            'field' => 'required|in:phone,interest1,interest2,city,profession',
            'value' => 'required|string|max:255',
        ]);

        $user = Auth::user();
     
        $profile = VolunteerProfile::firstOrCreate(['user_id' => $user->id]);

        $field = $request->input('field');
        $value = $request->input('value');

      
        if ($field === 'phone') {
            $user->phone = $value;
            $user->save();
        } else {
         
            $profile = VolunteerProfile::firstOrCreate(['user_id' => $user->id]);
            $profile->{$field} = $value;
            $profile->save();
        }

   
        return response()->json([
            'success' => true,
            'message' => ucfirst($field) . ' berhasil di‑update',
            'value' => $value,
        ]);
    }

    
    public function updatePassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->old_password, $user->password)) {
            return back()->with('error', 'Password lama salah');
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return back()->with('success', 'Password berhasil diubah');
    }

   
    public function updatePhoto(Request $request)
    {
        $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $user = Auth::user();

        if ($user->profile_photo) {
            Storage::disk('public')->delete($user->profile_photo);
        }

        $path = $request->file('photo')->store('profile_photos', 'public');
        $user->profile_photo = $path;
        $user->save();

        return back()->with('success', 'Foto profil berhasil diupdate');
    }
}
