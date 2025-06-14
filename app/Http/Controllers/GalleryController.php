<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Gallery;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    public function index()
    {
        $galleries = Gallery::where('user_id', auth()->id())->get();
        return view('dashboard.gallery', compact('galleries'));
    }

    public function store(Request $request)
{
    $request->validate([
        'image.*' => 'required|image|max:2048',
    ]);

    if ($request->hasFile('image')) {
        foreach ($request->file('image') as $file) {
            $path = $file->store('galleries', 'public');

            Gallery::create([
                'user_id' => auth()->id(),
                'image' => $path,
            ]);
        }
    }

    return back()->with('success', 'Gambar berhasil diunggah.');
}


    public function destroy(Gallery $gallery)
    {
        // Pastikan hanya pemilik yang bisa hapus
        if ($gallery->user_id !== auth()->id()) {
            abort(403);
        }

        Storage::disk('public')->delete($gallery->image);
        $gallery->delete();

        return back()->with('success', 'Gambar berhasil dihapus.');
    }

}
