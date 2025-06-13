<?php
namespace App\Http\Controllers;

use App\Models\Participation;
use Illuminate\Http\Request;

class SertifikasiController extends Controller
{

public function index()
{
    // Kalau ingin ambil semua data partisipasi
    $peserta = Participation::with(['user', 'event'])->get();

    // Kalau hanya peserta untuk event tertentu:
    // $peserta = Participation::where('event_id', $eventId)->with(['user', 'event'])->get();

    return view('auth.sertifikasi', compact('peserta'));
}
public function upload(Request $request, $id)
{
    $request->validate([
        'sertifikat' => 'required|file|mimes:pdf,jpg,png|max:2048',
    ]);

    $peserta = Participation::findOrFail($id);

    $path = $request->file('sertifikat')->store('sertifikat', 'public');

    $peserta->sertifikat = $path;
    $peserta->save();

    return redirect()->back()->with('success', 'Sertifikat berhasil diunggah!');
}

}
