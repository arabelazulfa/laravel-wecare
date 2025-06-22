<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Event;

class EventRegistered extends Notification
{
    public Event $event;

    public function __construct(Event $event)
    {
        $this->event = $event;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'title' => 'Pendaftaran Event Berhasil',
            'message' => 'Kamu berhasil mendaftar event "' . $this->event->title . '". Kami akan segera menghubungi kamu.',
            'url' => route('volunteer.events'),
            'event_id' => $this->event->id,
        ];
    }


}
