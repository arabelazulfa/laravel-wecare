<?php

namespace App\Http\Controllers;
use App\Notifications\EmergencyEventNotification;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Event;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class AktivitasController extends Controller
{
    // ================== TAMPILKAN DAFTAR AKTIVITAS ==================
    public function index()
    {
        $events = Event::where('organizer_id', Auth::id())->get();
        return view('auth.aktivitas_organisasi1', compact('events'));
    }

    // ================== LANGKAH 1: TAMPILKAN FORM PERTAMA ==================
    public function create()
    {
        return view('auth.aktivitas_organisasi2');
    }

    // ================== PROSES DARI LANGKAH 1 KE LANGKAH 2 ==================
    public function keLangkah2(Request $request)
    {
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
        ]);

        $data = $request->only([
            'title',
            'description',
            'category',
            'registration_deadline',
            'event_type',
            'location',
            'date',
            'start_time',
            'end_time'
        ]);

        // Simpan foto jika diunggah
        if ($request->hasFile('photo')) {
            $filename = $request->file('photo')->store('banners', 'public');
            $data['photo'] = $filename;
        }

        // Simpan data langkah 1 ke session
        $request->session()->put('aktivitas.step1', $data);

        return redirect()->route('aktivitas.langkah2');
    }

    // ================== LANGKAH 2: TAMPILKAN FORM KEDUA ==================
    public function langkah2()
    {
        return view('auth.aktivitas_organisasi3');
    }

    // ================== LANGKAH AKHIR: SIMPAN SEMUA DATA ==================
    public function simpan(Request $request)
    {
        // Validasi langkah 2
        $request->validate([
            'jenis_acara' => 'required|string|max:255',
            'divisi' => 'required|string|max:255',
            'tugas_relawan' => 'required|string',
            'kriteria' => 'required|string',
            'total_jam_kerja' => 'required|integer',
            'jumlah_relawan' => 'required|integer|min:1',
            'butuh_cv' => 'required|in:ya,tidak',
            'mode_darurat' => 'required|in:ya,tidak',
        ]);

        $step1 = $request->session()->get('aktivitas.step1');

        if (!$step1) {
            return redirect()->route('aktivitas.create')->with('error', 'Data dari langkah pertama tidak ditemukan. Silakan isi kembali.');
        }

        // Simpan ke database
        $event = new Event();
        $event->organizer_id = Auth::id();
        $event->title = $step1['title'];
        $event->description = $step1['description'];
        $event->category = $step1['category'];
        $event->registration_deadline = $step1['registration_deadline'];
        $event->event_type = $step1['event_type'];
        $event->location = $step1['location'];
        $event->date = $step1['date'];
        $event->start_time = $step1['start_time'];
        $event->end_time = $step1['end_time'];
        $event->photo = $step1['photo'] ?? null;

        $event->jenis_acara = $request->jenis_acara;
        $event->divisi = $request->divisi;
        $event->tugas_relawan = $request->tugas_relawan;
        $event->kriteria = $request->kriteria;
        $event->total_jam_kerja = $request->total_jam_kerja;
        $event->jumlah_relawan = $request->jumlah_relawan;
        $event->butuh_cv = $request->butuh_cv;
        $event->mode_darurat = $request->mode_darurat;
        $event->status = 'pending';

        $event->save();

        // Kirim notifikasi ke organisasi bahwa event telah berhasil dibuat
        $createdNotif = new \App\Notifications\EventCreatedNotification(
            $event->title,
            route('dashboard.organisasi', $event->id)
        );

        $organizer = User::find($event->organizer_id);
        if ($organizer) {
            $organizer->notify($createdNotif);
        }


        // 🚨 Kirim notifikasi jika mode darurat
        if ($event->mode_darurat === "ya") {
            \Log::info('✅ Mode darurat aktif! Mengirim notifikasi darurat.');

            // 🔴 Untuk Volunteer
            $volunteerUrl = route('events.detail.volunteer', $event->id);
            $notifVol = new EmergencyEventNotification(
                $event->title,
                $volunteerUrl,
                'volunteer' // jenis penerima
            );
            $volunteers = User::where('role', 'volunteer')->get();
            Notification::send($volunteers, $notifVol);

            // 🟣 Untuk Organisasi
            $orgUrl = route('dashboard.organisasi', $event->id);
            $notifOrg = new EmergencyEventNotification(
                $event->title,
                $orgUrl,
                'organisasi'
            );
            $organizer = User::find($event->organizer_id);
            if ($organizer) {
                $organizer->notify($notifOrg);
            }

        }

        // Bersihkan session setelah simpan
        $request->session()->forget('aktivitas.step1');

        return redirect()->route('aktivitas.index')->with('success', 'Aktivitas berhasil ditambahkan.');
    }
}
