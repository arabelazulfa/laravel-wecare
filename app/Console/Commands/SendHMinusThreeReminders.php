<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Event;
use App\Models\User;
use App\Models\Participation;
use App\Notifications\EventReminderVolunteer;
use App\Notifications\EventReminderOrg;

class SendHMinusThreeReminders extends Command
{
    protected $signature = 'reminder:h-3';
    protected $description = 'Kirim notifikasi H-3 ke relawan dan organisasi';

    public function handle()
    {
        $targetDate = now()->addDays(3)->toDateString();

        $events = Event::whereDate('date', $targetDate)->get();

        foreach ($events as $event) {

            // Kirim ke relawan yang diterima
            $participants = Participation::where('event_id', $event->id)
                ->where('verified', true)
                ->get();

            foreach ($participants as $part) {
                $user = User::find($part->user_id);
                if ($user) {
                    $user->notify(new EventReminderVolunteer($event));
                }
            }

            // Kirim ke organisasi (pemilik event)
            $orgUser = User::find($event->user_id); // pastikan kolom `user_id` di tabel events adalah ID user organisasi
            if ($orgUser) {
                $orgUser->notify(new EventReminderOrg($event));
            }
        }

        $this->info("Notifikasi H-3 berhasil dikirim ke relawan dan organisasi.");
    }
}
