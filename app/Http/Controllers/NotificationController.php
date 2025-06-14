<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;

use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    // public function index()
    // {
    //     $notifications = Notification::where('user_id', Auth::id())
    //                         ->orderBy('created_at', 'desc')
    //                         ->get();

    //     return view('notifications.index', compact('notifications'));
    // }
}
