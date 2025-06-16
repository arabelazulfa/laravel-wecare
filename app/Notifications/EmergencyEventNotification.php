<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EmergencyEventNotification extends Notification
{
    protected $eventTitle;
    protected $url;
    protected $receiverType;

    public function __construct($eventTitle, $url, $receiverType = 'volunteer')
    {
        $this->eventTitle = $eventTitle;
        $this->url = $url;
        $this->receiverType = $receiverType;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        $message = '';

        if ($this->receiverType === 'volunteer') {
            $message = "Event darurat \"{$this->eventTitle}\" membutuhkan relawan segera!<br>
                <a href=\"{$this->url}\" class=\"inline-block mt-1 px-3 py-1 bg-red-500 text-white text-xs rounded-md\">
                    Lihat Event
                </a>";
        } elseif ($this->receiverType === 'organisasi') {
            $message = "Kamu baru saja membuat event darurat \"{$this->eventTitle}\".<br>
                <a href=\"{$this->url}\" class=\"inline-block mt-1 px-3 py-1 bg-pink-400 text-white text-xs rounded-md\">
                    Lihat di Dashboard
                </a>";
        }

        return [
            'title' => '🚨 Mode Darurat Aktif',
            'message' => $message,
            'url' => $this->url,
        ];
    }
}
