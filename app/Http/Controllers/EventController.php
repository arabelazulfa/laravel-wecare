<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::all();
        return view('events.index', compact('events'));
    }

    public function show($id)
    {
        $event = Event::findOrFail($id);
        return view('events.show', compact('event'));
    }

    // EventController.php

    // public function showForVolunteer()
    // {
    //     $events = Event::with('organizer.organizationProfile')
    //         ->where('status', 'active')
    //         ->get();

    //     return view('events.volunteer-event', compact('events'));
    // }

    public function showForVolunteer()
    {
        $events = Event::latest()->get(); // TANPA FILTER status dulu

        return view('events.volunteer-event', compact('events'));
    }

    public function participants($id)
    {
        $event = Event::with('participants')->findOrFail($id);

    // Pastikan relasi 'participants' ada di model Event
        return view('events.participants', compact('event'));
    }

    public function showVolunteerDetail($id)
    {
        $event = Event::with(['participants', 'organizer.organizationProfile'])->findOrFail($id);
        return view('events.detailvol', compact('event'));
    }

}
