<?php


namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class OrganizationRegistered extends Notification
{
    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Pendaftaran Akun Organisasi Berhasil')
            ->greeting('Halo ' . $notifiable->name . ' 👋')
            ->line('Selamat! Akun organisasi kamu berhasil didaftarkan di platform kami.')
            ->action('Masuk ke Dashboard', url('/login'))
            ->line('Terima kasih telah bergabung!');
    }

    public function toDatabase($notifiable)
    {
        return [
            'title' => 'Pendaftaran Organisasi Berhasil',
            'message' => 'Selamat! Akun organisasi kamu berhasil terdaftar.',
            'url' => '/dashboard',
        ];
    }
}
