<?php

namespace App\Http\Controllers\Task;

use App\Helpers\ResponseHandler;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Task;
use Illuminate\Http\Request;

class UpdateTaskController extends Controller
{
    public function __invoke(UpdateTaskRequest $request, Task $task)
    {
        $task->update($request->validated());

        return ResponseHandler::success('Updated successfully', $task);
    }
}
