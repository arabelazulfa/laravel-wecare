<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class VolunteerJoinedEvent extends Notification
{
    protected $volunteerName;
    protected $eventTitle;
    protected $url;

    public function __construct($volunteerName, $eventTitle, $url)
    {
        $this->volunteerName = $volunteerName;
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
            'title' => '🎉 Volunteer Mendaftar Event',
            'message' => "{$this->volunteerName} telah mendaftar ke event \"{$this->eventTitle}\".<br><a href=\"{$this->url}\" class=\"inline-block mt-1 px-3 py-1 bg-pink-500 text-white text-xs rounded-md\">Lihat Daftar Relawan</a>",
            'url' => $this->url
        ];
    }
}
