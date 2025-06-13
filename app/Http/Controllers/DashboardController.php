<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EventRegistration;
use App\Models\OrganizationProfile;
use App\Models\Event;
use App\Models\EventReview;

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
                'id' => $reg->relawan->id,
                'nama' => $reg->relawan->name,
                'lokasi' => $reg->relawan->lokasi,
                'deskripsi' => $reg->relawan->deskripsi,
                'minat' => $reg->relawan->minat,
            ];
        });

        return view('dashboard.organisasi', compact('pendaftaranRelawan'));
    }
    public function profile()
    {
        $profile = OrganizationProfile::where('user_id', auth()->id())->first();
        $events = Event::where('organizer_id', auth()->id())->latest()->get();

        $reviews = EventReview::whereIn('event_id', $events->pluck('id'))->latest()->get();

        return view('dashboard.profile', compact('profile', 'events', 'reviews'));
    }


}
