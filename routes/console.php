<?php

use Illuminate\Support\Facades\Artisan;

Artisan::command('notify:user-upcoming-tasks', function () {
    $this->info('Notify users about their upcoming tasks');
})->dailyAt('00:00');

Schedule::call('mark:overdue-tasks')->dailyAt('00:00');
