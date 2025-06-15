<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use\App\Models\Event;

class EventReminderVolunteer extends Notification
{
    use Queueable;
    protected $event;

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
            'message' => 'Event "' . $this->event->title . '" akan dilaksanakan dalam 3 hari lagi! Pastikan kamu siap ya!',
            'event_id' => $this->event->id,
        ];
    }
}
