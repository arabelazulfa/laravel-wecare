<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\DatabaseMessage;
use Illuminate\Notifications\Notification;

class VolunteerAccepted extends Notification
{
    protected $eventTitle;
    protected $url;

    public function __construct($event)
    {
        $this->eventTitle = $event->title;
        $this->url = route('events.detail.organisasi', $event->id);
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'title' => '✅ Diterima sebagai Relawan',
            'message' => 'Selamat! Kamu telah diterima sebagai relawan untuk event <strong>"' . $this->eventTitle . '"</strong>. Terima kasih atas partisipasimu!',
            'url' => $this->url,
        ];
    }

}
