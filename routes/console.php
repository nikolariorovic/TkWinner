<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Briše rezervacije starije od 30 dana — svaku noć u 02:00
Schedule::command('reservations:prune')->dailyAt('02:00')->timezone('Europe/Belgrade');

// Šalje podsetnik mejl sat vremena pre termina — svaki minut
Schedule::command('reservations:remind')->everyMinute();
