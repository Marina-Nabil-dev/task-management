<?php

use App\Http\Controllers\Task\CreateTaskController;
use App\Http\Controllers\Task\DeleteTaskController;
use App\Http\Controllers\Task\GetAllTasksController;
use App\Http\Controllers\Task\UpdateTaskController;
use App\Http\Controllers\User\AssignTaskToUserController;
use App\Http\Controllers\User\GetUserTasksController;

Route::prefix('tasks')->group(function () {
    Route::post('/', CreateTaskController::class)->name('create-task');
    Route::get('/', GetAllTasksController::class)->name('tasks-all-get');
    Route::patch('{task:slug}', UpdateTaskController::class)->name('task-update');
    Route::delete('{task:slug}', DeleteTaskController::class)->name('task-delete');
    Route::post('assign-to-user/{task:slug}', AssignTaskToUserController::class)->name('assign.task');
});

Route::prefix('users')->group(function () {
    Route::get('{user}/tasks', GetUserTasksController::class)->name('user.tasks');

});
