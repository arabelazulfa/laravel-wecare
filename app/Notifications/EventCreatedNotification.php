<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EventCreatedNotification extends Notification
{
    use Queueable;

    protected $eventTitle;
    protected $url;

    public function __construct($eventTitle, $url)
    {
        $this->eventTitle = $eventTitle;
        $this->url = $url;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'title' => '✅ Event Berhasil Dibuat',
            'message' => "Kamu berhasil membuat event <strong>\"{$this->eventTitle}\"</strong>.<br>
                <a href=\"{$this->url}\" class=\"inline-block mt-1 px-3 py-1 bg-green-600 text-white text-xs rounded-md\">
                    Lihat di Dashboard
                </a>",
            'url' => $this->url,
        ];
    }
}
