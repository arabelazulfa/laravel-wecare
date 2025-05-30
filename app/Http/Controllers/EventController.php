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

    public function showForVolunteer()
    {
        $events = Event::with('organizer.organizationProfile')
            ->where('status', 'active')
            ->get();

        return view('events.volunteer-event', compact('events'));
    }


}
