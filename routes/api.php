<?php

use App\Http\Controllers\Task\CreateTaskController;
use App\Http\Controllers\Task\GetAllTasksController;

Route::prefix('tasks')->group(function () {
    Route::post('/', CreateTaskController::class);
    Route::get('/', GetAllTasksController::class);
    Route::patch('/{task:slug}',);
});
