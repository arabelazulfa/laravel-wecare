<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventRegistration;
use App\Notifications\EventRegistered;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 

class EventRegistrationController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'event_id'   => 'required|exists:events,id',
            'reason'     => 'required|string|max:1000',
            'why_you'    => 'required|string|max:1000',
            'division'   => 'nullable|string|max:100',
            'cv_file'    => 'required|mimes:pdf|max:2048',
        ]);

        $path = $request->file('cv_file')->store('cv', 'public');

        EventRegistration::create([
            'user_id'       => $request->user()->id,
            'event_id'      => $request->event_id,
            'division'      => $request->division,
            'reason'        => $request->reason,
            'why_you'       => $request->why_you,
            'cv_file'       => $path,
            'status'        => 'pending',
            'registered_at' => now(),
        ]);

        $event = Event::find($request->event_id);
        $request->user()->notify(new EventRegistered($event));

        return redirect()->back()->with('success', true);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'event_id' => 'required|exists:events,id',
            'reason' => 'required|string',
            'why_you' => 'required|string',
            'division' => 'required|string',
            'cv_file' => 'nullable|file|mimes:pdf|max:2048',
        ]);

        if ($request->hasFile('cv_file')) {
            $data['cv_file'] = $request->file('cv_file')->store('cv', 'public');
        }

        $data['user_id'] = auth()->id();
        EventRegistration::create($data);

        $event = Event::find($data['event_id']);
        Auth::user()->notify(new EventRegistered($event));

        // 🎁 balikin respon JSON aja (AJAX nggak butuh redirect)
        return response()->json(['message' => 'Pendaftaran berhasil!']);
    }

}
