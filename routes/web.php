<?php

use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('send-mail', function () {
    $user = User::first();
    dd($user);
    $user->update([
        'email' => 'engMarina97@gmail.com',
    ]);
    dd($user);
    $user->notify(new \App\Notifications\TaskDueNotification($user->tasks->first()));
});
