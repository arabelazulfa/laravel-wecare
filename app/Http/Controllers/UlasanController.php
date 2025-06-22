<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\EventReview;
use Illuminate\Support\Facades\Auth;

class UlasanController extends Controller
{
   
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

        return redirect()->route('dashuser')->with('success', 'Ulasan berhasil dikirim!');
    }
}
