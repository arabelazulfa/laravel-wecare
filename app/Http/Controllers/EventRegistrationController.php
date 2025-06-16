<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventRegistration;
use App\Notifications\EventRegistered;
use App\Models\Participation;
use App\Models\Events;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class EventRegistrationController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'event_id' => 'required|exists:events,id',
            'reason' => 'required|string|max:1000',
            'why_you' => 'required|string|max:1000',
            'division' => 'nullable|string|max:100',
            'cv_file' => 'required|mimes:pdf|max:2048',
        ]);

        $path = $request->file('cv_file')->store('cv', 'public');

        EventRegistration::create([
            'user_id' => $request->user()->id,
            'event_id' => $request->event_id,
            'division' => $request->division,
            'reason' => $request->reason,
            'why_you' => $request->why_you,
            'cv_file' => $path,
            'status' => 'pending',
            'registered_at' => now(),
        ]);

        $event = Event::find($request->event_id);
        $request->user()->notify(new EventRegistered($event));

        // 🔔 Kirim notifikasi ke organisasi
        $orgUser = $event->organizer; // asumsi relasi event -> organization -> user

        $volunteerName = $request->user()->name;
        $eventTitle = $event->title;
        $routeToDashboard = route('dashboard.organisasi');


        $orgUser->notify(new \App\Notifications\VolunteerJoinedEvent(
            $volunteerName,
            $eventTitle,
            $routeToDashboard
        ));

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


    public function accept(Request $request)
    {

        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'event_id' => 'required|exists:events,id',
        ]);

        // Insert jika belum ada, update jika sudah
        Participation::updateOrCreate(
            [
                'user_id' => $validated['user_id'],
                'event_id' => $validated['event_id'],
            ],
            [
                'verified' => true, // gunakan 'verified' untuk status 'diterima'
            ]
        );
        // Update status juga di tabel event_registrations
        EventRegistration::where('user_id', $validated['user_id'])
            ->where('event_id', $validated['event_id'])
            ->update(['status' => DB::raw("'accepted'")]);

        // Kirim notifikasi
        $volunteer = User::find($validated['user_id']);
        $event = Event::find($validated['event_id']);
        $volunteer->notify(new \App\Notifications\VolunteerAccepted($event));

        return back()->with([
            'success' => 'Relawan berhasil diterima.',
            'event_id' => $validated['event_id'],
        ]);

    }
}
