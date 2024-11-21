<?php

use App\Http\Controllers\Task\TaskController;
use App\Http\Controllers\User\AssignTaskToUserController;
use App\Http\Controllers\User\GetUserTasksController;

Route::prefix('tasks')->group(function () {
    Route::post('/', [TaskController::class, 'create'])->name('task.create');
    Route::get('/', [TaskController::class, 'getAllTasks'])->name('task.get-all-tasks');
    Route::patch('/{task:slug}', [TaskController::class, 'update'])->name('task.update');
    Route::delete('/{task:slug}', [TaskController::class, 'delete'])->name('task.delete');
    Route::post('assign-to-user/{task:slug}', AssignTaskToUserController::class)->name('assign.task');
});

Route::prefix('users')->group(function () {
    Route::get('{user}/tasks', GetUserTasksController::class)->name('user.tasks');

});
