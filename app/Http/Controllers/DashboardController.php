<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\EventRegistration;
use App\Models\OrganizationProfile;
use App\Models\Event;
use App\Models\EventReview;
use App\Models\Gallery;
use App\Models\User;


class DashboardController extends Controller
{
    public function index()
    {
        //PUNYA VOLUNTEER 
        $user = auth()->user();

        // Ambil event yang diikutin user, include relasi ke tabel events
        $registeredEvents = EventRegistration::with('event')
            ->where('user_id', $user->id)
            ->get()
            ->pluck('event'); // cuma ambil data event-nya

        return view('dashuser', compact('registeredEvents'));
    }


    public function organisasi()
    {
        $pendaftaranRelawan = EventRegistration::with('relawan')->get()->map(function ($reg) {
            return (object) [
                'id' => $reg->user->id ?? null,
                'name' => $reg->user->name ?? 'Tidak diketahui',
                'city' => optional($reg->user->volunteerProfile)->city ?? 'Tidak tersedia',
                'reason' => $reg->reason ?? 'Belum diisi',
                'division' => $reg->division ?? 'Belum ditentukan',
            ];

        });

        $user = auth()->user(); // ini organisasi

        $notifications = $user->notifications()->latest()->take(5)->get();
        $unreadCount = $user->unreadNotifications()->count();

        return view('dashboard.organisasi', compact('pendaftaranRelawan', 'notifications', 'unreadCount'));
    }
    public function profile()
    {
        $profile = OrganizationProfile::where('user_id', auth()->id())->first();
        $events = Event::where('organizer_id', auth()->id())->latest()->get();
        $galleries = Gallery::where('user_id', auth()->id())->get();

        $reviews = EventReview::whereIn('event_id', $events->pluck('id'))->latest()->get();

        return view('dashboard.profile', compact('profile', 'events', 'reviews', 'galleries'));
    }

    public function updateLogo(Request $request)
    {
        $request->validate([
            'logo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $profile = OrganizationProfile::where('user_id', auth()->id())->first();


        // Hapus logo lama kalau ada
        if ($profile->logo && Storage::exists('public/logos/' . $profile->logo)) {
            Storage::delete('public/logos/' . $profile->logo);
        }

        // Simpan logo baru
        $file = $request->file('logo');
        $filename = time() . '_' . $file->getClientOriginalName();
        $file->storeAs('public/logos', $filename);

        // Update di database
        $profile->logo = $filename;
        $profile->save();

        return back()->with('success', 'Logo berhasil diperbarui.');
    }




}
