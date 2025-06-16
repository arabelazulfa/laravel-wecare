<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        \App\Console\Commands\SendHMinusThreeReminders::class,
    ];

    protected function schedule(Schedule $schedule)
    {
        $schedule->command('reminder:h-3')->dailyAt('08:00'); // Ganti jam jika perlu
    }

    protected function commands()
    {
        $this->load(__DIR__.'/Commands');
        require base_path('routes/console.php');
    }
}
