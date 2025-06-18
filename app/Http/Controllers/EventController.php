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
                ->with('user') // agar bisa tampil nama relawan
                ->get();

    return view('events.show', compact('event', 'reviews'));
    }  


    // EventController.php

    // public function showForVolunteer()
    // {
    //     $events = Event::with('organizer.organizationProfile')
    //         ->where('status', 'active')
    //         ->get();

    //     return view('events.volunteer-event', compact('events'));
    // }

    public function showForVolunteer(Request $request)
    {
        $query = Event::with('organizer.organizationProfile');

        // 🔍 Search by title / nama organisasi
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%$search%")
                    ->orWhereHas('organizer.organizationProfile', function ($sub) use ($search) {
                        $sub->where('org_name', 'like', "%$search%");
                    });
            });
        }

        // 📍 Filter by lokasi
        if ($request->filled('location')) {
            $query->where('location', 'like', "%{$request->location}%");
        }

        // 📆 Filter by tanggal
        if ($request->filled('date')) {
            $query->whereDate('date', $request->date);
        }

        // 🎯 Filter by tipe kegiatan
        if ($request->filled('event_type')) {
            $query->where('event_type', $request->event_type);
        }

        // 💡 Filter by minat
        if ($request->filled('interest')) {
            $query->where('category', 'like', "%{$request->interest}%");
        }

        // 🚀 Ambil hasilnya
        $events = $query->latest()->get();

        // Buat opsi filter dropdown (optional, bisa custom)
        $eventTypes = Event::select('event_type')->distinct()->pluck('event_type');
        $category = ['Lingkungan', 'Sosial', 'Pendidikan']; // bisa diganti dari DB juga

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


    // ================== TAMPILKAN FORM EDIT ==================
    public function edit($id)
    {
        $event = Event::findOrFail($id);
        return view('events.edit_events', compact('event'));
    }

    // ================== PROSES UPDATE EVENT ==================
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

        // Proses foto jika diunggah
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

    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'title' => 'required|string|max:255',
    //         'description' => 'required|string',
    //         'category' => 'required|string',
    //         'registration_deadline' => 'required|date',
    //         'event_type' => 'required|string',
    //         'location' => 'required|string',
    //         'date' => 'required|date',
    //         'start_time' => 'required|date_format:H:i',
    //         'end_time' => 'required|date_format:H:i|after:start_time',
    //         'jenis_acara' => 'required|string',
    //         'divisi' => 'required|string',
    //         'tugas_relawan' => 'required|string',
    //         'kriteria' => 'required|string',
    //         'total_jam_kerja' => 'required|integer',
    //         'jumlah_relawan' => 'required|integer',
    //         'butuh_cv' => 'required|in:ya,tidak',
    //         'mode_darurat' => 'required|in:ya,tidak',
    //         'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
    //     ]);

    //     $photoPath = null;
    //     if ($request->hasFile('photo')) {
    //         $photoPath = $request->file('photo')->store('banners', 'public');
    //     }

    //     $event = Event::create([
    //         'organizer_id' => Auth::id(),
    //         'title' => $request->title,
    //         'description' => $request->description,
    //         'category' => $request->category,
    //         'registration_deadline' => $request->registration_deadline,
    //         'event_type' => $request->event_type,
    //         'location' => $request->location,
    //         'date' => $request->date,
    //         'start_time' => $request->start_time,
    //         'end_time' => $request->end_time,
    //         'jenis_acara' => $request->jenis_acara,
    //         'divisi' => $request->divisi,
    //         'tugas_relawan' => $request->tugas_relawan,
    //         'kriteria' => $request->kriteria,
    //         'total_jam_kerja' => $request->total_jam_kerja,
    //         'jumlah_relawan' => $request->jumlah_relawan,
    //         'butuh_cv' => $request->butuh_cv,
    //         'mode_darurat' => $request->mode_darurat,
    //         'photo' => $photoPath,
    //     ]);
    //     dd($event->mode_darurat);
    //     $event->refresh();
    //     // 🚨 Kirim notifikasi jika mode darurat
    //     if ($event->mode_darurat === "ya") {
    //          \Log::info('✅ Mode darurat aktif! Mengirim notifikasi darurat.');
    //         $eventUrl = route('events.show', $event->id);
    //         $notif = new EmergencyEventNotification($event->title, $eventUrl);

    //         // kirim ke semua volunteer
    //         $volunteers = User::where('role', 'volunteer')->get();
    //         Notification::send($volunteers, $notif);

    //         // kirim ke organisasi pembuat event juga
    //         Auth::user()->notify($notif);
    //     }

    //     return redirect()->route('dashboard.organisasi')->with('success', 'Event berhasil dibuat.');
    // }


}
