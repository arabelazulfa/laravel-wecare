<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\EventReview;
use Illuminate\Support\Facades\Auth;

class UlasanController extends Controller
{
    // Tampilkan form ulasan
    // public function create($eventId)
    // {
    //     $event = Event::findOrFail($eventId);
    //     return view('components.ulasan', compact('event'));
    // }

    // Simpan ulasan ke database
    public function store(Request $request)
    {
        $request->validate([
            'review' => 'required|string',
            'event_id' => 'required|exists:events,id',
        ]);

        EventReview::create([
            'user_id' => Auth::id(),
            'event_id' => $request->event_id,
            'review' => $request->review,
        ]);

        return redirect()->route('volunteer.event')->with('success', 'Ulasan berhasil dikirim!');
    }
}
