<?php
// app/Notifications/VolunteerRegistered.php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class VolunteerRegistered extends Notification
{
    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Pendaftaran Akun Volunteer Berhasil')
            ->greeting('Halo ' . $notifiable->name . ' 👋')
            ->line('Selamat! Akun volunteer kamu berhasil didaftarkan di platform kami.')
            ->action('Masuk ke Dashboard', url('/login'))
            ->line('Terima kasih telah bergabung!');
    }

    public function toDatabase($notifiable)
    {
        return [
            'title' => 'Pendaftaran Volunteer Berhasil',
            'message' => 'Selamat! Akun volunteer kamu berhasil terdaftar.',
            'url' => '/dashboard',
        ];
    }
}
