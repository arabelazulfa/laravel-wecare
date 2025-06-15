<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\DatabaseMessage;
use Illuminate\Notifications\Notification;

class VolunteerAccepted extends Notification
{
    protected $eventTitle;

    public function __construct($eventTitle)
    {
        $this->eventTitle = $eventTitle;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'message' => 'Selamat! Kamu diterima sebagai relawan untuk event "' . $this->eventTitle . '"',
        ];
    }
}
