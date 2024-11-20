<?php

namespace App\Jobs;

use App\Enums\TaskStatusEnum;
use App\Models\Task;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class MarkOverdueTasksJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct() {}

    public function handle(): void
    {
        $tasks = Task::where('due_date', '<', now())
            ->whereIn('status', [TaskStatusEnum::NEW, TaskStatusEnum::IN_PROGRESS])->get();

        $tasks->each(function ($task) {
            $task->update(['status' => TaskStatusEnum::OVERDUE]);
        });
    }
}
