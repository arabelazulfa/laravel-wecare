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
use App\Models\VolunteerProfile;


class DashboardController extends Controller
{
    public function index()
    {
       
        $user = auth()->user();

        $registeredEvents = EventRegistration::with('event')
            ->where('user_id', $user->id)
            ->where('status', 'accepted')
            ->get()
            ->pluck('event'); 

        return view('dashuser', compact('registeredEvents'));
    }


    public function organisasi()
    {
        $organisasiId = auth()->id();
        $events = Event::where('organizer_id', $organisasiId)->with(['registrations.user.volunteerProfile'])->get();

        $groupedRegistrations = $events->map(function ($event) {
            return (object) [
                'event_id' => $event->id,
                'event_title' => $event->title,
                'registrations' => $event->registrations->map(function ($reg) use ($event) {
                    return (object) [
                        'id' => $reg->user->id ?? null,
                        'name' => $reg->user->name ?? 'Tidak diketahui',
                        'city' => optional($reg->user->volunteerProfile)->city ?? 'Tidak tersedia',
                        'reason' => $reg->reason ?? 'Belum diisi',
                        'division' => $reg->division ?? 'Belum ditentukan',
                        'profile_photo' => $reg->user->profile_photo ?? null,
                        'event_id' => $event->id,
                    ];
                }),
            ];
        });

        $user = auth()->user();
        $notifications = $user->notifications()->latest()->take(5)->get();
        $unreadCount = $user->unreadNotifications()->count();


        return view('dashboard.organisasi', compact('groupedRegistrations', 'notifications', 'unreadCount'));
    }

    public function profildaftar($id)
    {
        $user = User::with('volunteerProfile')->findOrFail($id);
        $volProfile = VolunteerProfile::where('user_id', $id)->first();
        $eventRegistration = EventRegistration::where('user_id', $user->id)->latest()->first();
        $validInterests = ['Kesehatan', 'Lingkungan', 'Pendidikan', 'Kemanusiaan', 'Teknologi', 'Sosial'];

        return view('dashboard.profildaftar', compact('user', 'volProfile', 'eventRegistration', 'validInterests'));
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


      
        if ($profile->logo && Storage::exists('public/logos/' . $profile->logo)) {
            Storage::delete('public/logos/' . $profile->logo);
        }

       
        $file = $request->file('logo');
        $filename = time() . '_' . $file->getClientOriginalName();
        $file->storeAs('public/logos', $filename);

     
        $profile->logo = $filename;
        $profile->save();

        return back()->with('success', 'Logo berhasil diperbarui.');
    }




}
