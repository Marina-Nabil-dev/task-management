<?php

use App\Livewire\ListTasks;
use App\Livewire\Login;
use App\Livewire\Register;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/login', Login::class)->name('login');
Route::get('/register', Register::class)->name('register');
Route::middleware('auth:sanctum')
    ->group(function () {
        Route::get('/tasks', ListTasks::class)->name('tasks');
    });
