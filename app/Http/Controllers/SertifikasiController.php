<?php
namespace App\Http\Controllers;

use App\Models\Participation;
use Illuminate\Http\Request;
use App\Models\Presensi;
use App\Models\Certificate;
class SertifikasiController extends Controller
{

public function index()
{
    // Kalau ingin ambil semua data partisipasi
    $peserta = Presensi::with(['user', 'event', 'certificate'])->get();

    // Kalau hanya peserta untuk event tertentu:
    // $peserta = Participation::where('event_id', $eventId)->with(['user', 'event'])->get();

    return view('auth.sertifikasi', compact('peserta'));
}
public function upload(Request $request, $id)
{
    $request->validate([
        'sertifikat' => 'required|file|mimes:pdf,jpg,png|max:2048',
    ]);

    $peserta = Participation::with('event')->findOrFail($id);
    $path = $request->file('sertifikat')->store('sertifikat', 'public');

    Certificate::create([
        'user_id'     => $peserta->user_id,
        'event_id'    => $peserta->event_id,
        'file_path'   => $path,
        'issued_at'   => now(),
    ]);

    return redirect()->back()->with('success', 'Sertifikat berhasil diunggah!');
}

}
