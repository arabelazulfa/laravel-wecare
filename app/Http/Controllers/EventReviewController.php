<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EventReview;
use Illuminate\Support\Facades\Auth;

class EventReviewController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'event_id' => 'required|exists:events,id',
            'review' => 'required|string|max:1000',
        ]);

        EventReview::create([
            'user_id' => auth()->id(),
            'event_id' => $request->event_id,
            'review' => $request->review,
        ]);

        return back()->with('success', 'Ulasan berhasil dikirim!');
    }
}
