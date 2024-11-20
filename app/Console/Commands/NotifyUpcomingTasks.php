<?php

namespace App\Console\Commands;

use App\Enums\TaskStatusEnum;
use App\Models\Task;
use App\Notifications\TaskDueNotification;
use Illuminate\Console\Command;

class NotifyUpcomingTasks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notify:user-upcoming-tasks';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Notify users about their upcoming tasks';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $tasks = Task::where('due_date', '<=', now()->addDay())
            ->where('status', TaskStatusEnum::NEW)
            ->get();

        foreach ($tasks as $task) {
            $task->users()->each(function ($user) use ($task) {
                $user->notify(new TaskDueNotification($task));
            });
        }
    }
}
