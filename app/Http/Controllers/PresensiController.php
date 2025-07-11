<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Presensi;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PresensiController extends Controller
{

    public function show($eventId)
    {
        $event = Event::findOrFail($eventId);
        $user = Auth::user();

        return view('presensi.form', compact('event', 'user'));
    }

    
    public function store(Request $request)
    {
        $request->validate([
            'event_id' => 'required|exists:events,id',
            'attendance_time' => 'required|date',
            'attendance_photo' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $userId = auth()->id();

    
        $alreadyExists = Presensi::where('user_id', $userId)
            ->where('event_id', $request->event_id)
            ->exists();

        if ($alreadyExists) {
            return redirect()->route('dashuser')->with('error', 'Kamu sudah presensi di event ini!');
        }

    
        $photoPath = $request->file('attendance_photo')->store('presensi', 'public');

        Presensi::create([
            'user_id' => Auth::id(),
            'event_id' => $request->event_id,
            'attendance_time' => $request->attendance_time,
            'attendance_photo' => $photoPath,
        ]);

        return redirect()->route('dashuser')->with('success', 'Presensi berhasil dikirim!');
    }
}
