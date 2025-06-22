<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Notifications\EmergencyEventNotification;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Notification;

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

    $reviews = \App\Models\EventReview::where('event_id', $id)
                ->with('user') 
                ->get();

    return view('events.show', compact('event', 'reviews'));
    }  



    public function showForVolunteer(Request $request)
    {
        $query = Event::with('organizer.organizationProfile');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%$search%")
                    ->orWhereHas('organizer.organizationProfile', function ($sub) use ($search) {
                        $sub->where('org_name', 'like', "%$search%");
                    });
            });
        }

      
        if ($request->filled('location')) {
            $query->where('location', 'like', "%{$request->location}%");
        }

        if ($request->filled('date')) {
            $query->whereDate('date', $request->date);
        }

        
        if ($request->filled('event_type')) {
            $query->where('event_type', $request->event_type);
        }

      
        if ($request->filled('interest')) {
            $query->where('category', 'like', "%{$request->interest}%");
        }

        $events = $query->latest()->get();

        $eventTypes = Event::select('event_type')->distinct()->pluck('event_type');
        $category = ['Lingkungan', 'Sosial', 'Pendidikan']; 

        return view('events.volunteer-event', compact('events', 'eventTypes', 'category'));
    }


    public function participants($id)
    {
        $event = Event::with('participants')->findOrFail($id);
        return view('events.participants', compact('event'));
    }

    public function showVolunteerDetail($id)
    {
        $event = Event::with(['participants', 'organizer.organizationProfile'])->findOrFail($id);
        return view('events.detailvol', compact('event'));
    }


    
    public function edit($id)
    {
        $event = Event::findOrFail($id);
        return view('events.edit_events', compact('event'));
    }

    
    public function update(Request $request, $id)
    {
        $event = Event::findOrFail($id);
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|string',
            'registration_deadline' => 'required|date',
            'event_type' => 'required|string',
            'location' => 'required|string',
            'date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'jenis_acara' => 'required|string',
            'divisi' => 'required|string',
            'tugas_relawan' => 'required|string',
            'kriteria' => 'required|string',
            'total_jam_kerja' => 'required|integer',
            'jumlah_relawan' => 'required|integer',
            'butuh_cv' => 'required|in:ya,tidak',
            'mode_darurat' => 'required|in:ya,tidak',
        ]);

        $event->update([
            'organizer_id' => Auth::id(),
            'title' => $request->title,
            'description' => $request->description,
            'category' => $request->category,
            'registration_deadline' => $request->registration_deadline,
            'event_type' => $request->event_type,
            'location' => $request->location,
            'date' => $request->date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'jenis_acara' => $request->jenis_acara,
            'divisi' => $request->divisi,
            'tugas_relawan' => $request->tugas_relawan,
            'kriteria' => $request->kriteria,
            'total_jam_kerja' => $request->total_jam_kerja,
            'jumlah_relawan' => $request->jumlah_relawan,
            'butuh_cv' => $request->butuh_cv,
            'mode_darurat' => $request->mode_darurat,
        ]);

       
        if ($request->hasFile('photo')) {
            if ($event->photo && Storage::disk('public')->exists($event->photo)) {
                Storage::disk('public')->delete($event->photo);
            }
            $filename = $request->file('photo')->store('banners', 'public');
            $event->photo = $filename;
            $event->save();
        }

        return redirect()->route('events.show', $event->id)->with('success', 'Aktivitas berhasil diperbarui.');
    }
    public function destroy($id)
    {
        $event = Event::findOrFail($id);
        $event->delete();

        return redirect()->route('aktivitas.index')->with('success', 'Event berhasil dihapus.');
    }

    public function showParticipants($id)
    {
        $event = Event::with('participants')->findOrFail($id);
        return view('events.participants', compact('event'));
    }

    public function presensi($id)
    {
        $event = Event::with(['presensis.user'])->findOrFail($id);
        return view('events.presensi', compact('event'));
    }



}
