<?php

namespace App\Http\Controllers\Task;

use App\Enums\TaskStatusEnum;
use App\Helpers\ResponseHandler;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateTaskRequest;
use App\Http\Requests\GetAllTasksRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Http\Resources\TaskResource;
use App\Models\Task;

class TaskController extends Controller
{
    public function getAllTasks(GetAllTasksRequest $request)
    {
        $tasksQuery = Task::query();

        if ($request->has('status')) {
            $tasksQuery->whereStatus($request->status);
        }

        if ($request->has('date_from') && $request->has('date_to')) {
            $tasksQuery->whereBetween('due_date', [$request->date_from, $request->date_to]);

        }
        $tasks = $tasksQuery->paginate($request->get('per_page', 10));

        return ResponseHandler::success('Tasks fetched successfully', TaskResource::collection($tasks));
    }

    public function create(CreateTaskRequest $request)
    {
        Task::create([
            ...$request->validated(),
            'status' => TaskStatusEnum::NEW,
        ]);

        return ResponseHandler::success('Task created successfully');
    }

    public function update(UpdateTaskRequest $request, Task $task)
    {
        $task->update($request->validated());

        return ResponseHandler::success('Updated successfully');
    }

    public function delete(Task $task)
    {
        $task->delete();

        return ResponseHandler::success('Task deleted successfully');
    }
}
