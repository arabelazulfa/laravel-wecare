<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use Illuminate\Support\Facades\Auth;

class AktivitasController extends Controller
{
    // Langkah 1: Tampilkan form pertama
    public function index()
    {
        return view('auth.aktivitas_organisasi1');
    }

    // Langkah 2: Tampilkan form kedua
    public function langkah2()
    {
        return view('auth.aktivitas_organisasi2');
    }

    // Langkah 1: Tangani data dan arahkan ke langkah 2
    public function keLangkah2(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required',
            'registration_deadline' => 'required|date',
            'event_type' => 'required',
            'location' => 'required|string',
            'alamat' => 'required|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Simpan sementara ke session
        $data = $request->all();

        // Simpan file foto jika diunggah
        if ($request->hasFile('photo')) {
            $filename = $request->file('photo')->store('banners', 'public');
            $data['photo'] = $filename;
        }

        $request->session()->put('aktivitas_step1', $data);

        return redirect()->route('aktivitas.langkah2');
    }

    // Langkah 3: Simpan ke database
    public function simpan(Request $request)
    {
        $step1 = $request->session()->get('aktivitas_step1');

        if (!$step1) {
            return redirect()->route('aktivitas.index')->with('error', 'Data tidak ditemukan. Silakan ulangi langkah 1.');
        }

        $event = new Event();
        $event->organizer_id = Auth::id();
        $event->title = $step1['title'];
        $event->description = $step1['description'];
        $event->category = $step1['category'];
        $event->registration_deadline = $step1['registration_deadline'];
        $event->event_type = $step1['event_type'];
        $event->location = $step1['location'];
        $event->alamat = $step1['alamat'];
        $event->photo = $step1['photo'] ?? null; // jika ada

        $event->jenis_acara = $request->jenis_acara;
        $event->divisi = $request->divisi;
        $event->tugas = $request->tugas;
        $event->kriteria = $request->kriteria;
        $event->total_jam = $request->total_jam;
        $event->jumlah_relawanan = $request->jumlah_relawan;
        $event->perlu_cv = $request->perlu_cv;
        $event->mode_darurat = $request->mode_darurat;

        $event->status = 'pending';
        $event->created_at = now();
        $event->updated_at = now();
        $event->save();

        $request->session()->forget('aktivitas_step1');

        return redirect()->route('dashboardorg')->with('success', 'Aktivitas berhasil ditambahkan.');
    }
}
