<?php

namespace App\Http\Controllers\User;

use App\Helpers\ResponseHandler;
use App\Http\Controllers\Controller;
use App\Http\Resources\TaskResource;
use App\Models\User;

class GetUserTasksController extends Controller
{
    public function __invoke(User $user)
    {
        $tasks = $user->tasks;

        return ResponseHandler::success("User's tasks", TaskResource::collection($tasks));
    }
}
