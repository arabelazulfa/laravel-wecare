<?php

namespace App\Http\Controllers;

use App\Models\EventRegistration;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

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

        return redirect()->back()->with('success', true);
    }
}
