<?php

namespace App\Http\Controllers\Task;

use App\Enums\TaskStatusEnum;
use App\Helpers\ResponseHandler;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateTaskRequest;
use App\Models\Task;

class CreateTaskController extends Controller
{
    public function __invoke(CreateTaskRequest $request)
    {
        Task::create([
            ...$request->validated(),
            'status' => TaskStatusEnum::NEW
        ]);

        return ResponseHandler::success('Task created successfully');

    }
}
