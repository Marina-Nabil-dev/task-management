<?php

namespace App\Http\Controllers\Task;

use App\Helpers\ResponseHandler;
use App\Models\Task;

class DeleteTaskController
{
    public function __invoke(Task $task)
    {
        $task->delete();

        return ResponseHandler::success('Task deleted successfully');
    }
}
