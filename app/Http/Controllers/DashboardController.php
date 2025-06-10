<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EventRegistration;

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
}
