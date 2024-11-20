<?php

namespace App\Http\Controllers\User;

use App\Helpers\ResponseHandler;
use App\Http\Controllers\Controller;
use App\Http\Requests\AssignUserTaskRequest;
use App\Models\Task;
use App\Models\User;

class AssignTaskToUserController extends Controller
{
    public function __invoke(AssignUserTaskRequest $request, Task $task)
    {
        $validated = $request->validated();

        $user = User::whereEmail($validated['email'])->first();

        $user->tasks()->syncWithoutDetaching([$task->id]);

        return ResponseHandler::success('Task assigned successfully');
    }
}
