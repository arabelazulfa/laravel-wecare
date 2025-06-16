<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use App\Console\Commands\SendHMinusThreeReminders;


Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('send:hminusthree', function () {
    $this->call(SendHMinusThreeReminders::class);
})->purpose('Mengirim notifikasi H-3 ke relawan dan organisasi');
