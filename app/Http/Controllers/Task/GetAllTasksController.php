<?php

namespace App\Http\Controllers\Task;

use App\Helpers\ResponseHandler;
use App\Http\Controllers\Controller;
use App\Http\Requests\GetAllTasksRequest;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use Illuminate\Http\Request;

class GetAllTasksController extends Controller
{
    public function __invoke(GetAllTasksRequest $request)
    {
        $tasksQuery = Task::query();

        if ($request->has('status'))
        {
            $tasksQuery->whereStatus($request->status);
        }

        if ($request->has('date_from') && $request->has('date_to'))
        {
            $tasksQuery->whereBetween('due_date', [$request->date_from, $request->date_to]);

        }
        $tasks = $tasksQuery->paginate($request->get('per_page', 10));

        return ResponseHandler::success('Tasks fetched successfully', TaskResource::collection($tasks));

    }
}
