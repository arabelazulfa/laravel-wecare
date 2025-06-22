<?php
namespace App\Http\Controllers;

use App\Models\Participation;
use Illuminate\Http\Request;
use App\Models\Presensi;
use App\Models\Certificate;
use App\Models\Event;
class SertifikasiController extends Controller
{


public function index()
{
   
    $events = Event::with(['presensis.user', 'certificates'])
        ->where('organizer_id', auth()->id())
        ->get();

    return view('auth.sertifikasi', compact('events'));
}

public function upload(Request $request, $id)
{
    $request->validate([
        'sertifikat' => 'required|file|mimes:pdf,jpg,png|max:2048',
    ]);

    $presensi = Presensi::with('event')->findOrFail($id);

    if (!$request->hasFile('sertifikat')) {
        return back()->withErrors(['File tidak ditemukan saat upload.']);
    }

    $file = $request->file('sertifikat');
    $path = $file->store('sertifikat', 'public');
    
    if (!$path) {
        return back()->withErrors(['File gagal disimpan ke storage.']);
    }

    Certificate::create([
        'user_id'   => $presensi->user_id,
        'event_id'  => $presensi->event_id,
        'file_path' => $path,
        'issued_at' => now(),
    ]);

    return redirect()->back()->with('success', 'Sertifikat berhasil diunggah!');
}


}
