<?php

namespace App\Livewire;

use App\Models\Task;
use Livewire\Component;
use Livewire\WithPagination;

class ListTasks extends Component
{
    use WithPagination;

    public $filter = '';
    protected $listeners = ['taskUpdated' => '$refresh', 'taskCreated' => '$refresh'];

    public function updateTaskStatus($taskId)
    {
        $task = Task::find($taskId);
        if ($task && $task->user_id === auth()->id()) {
            $task->status = $task->status === 'completed' ? 'pending' : 'completed';
            $task->save();
            $this->dispatch('taskUpdated');
        }
    }

    public function deleteTask($taskId)
    {
        $task = Task::find($taskId);
        if ($task && $task->user_id === auth()->id()) {
            $task->delete();
            $this->dispatch('taskUpdated');
        }
    }

    public function render()
    {
        $query = auth()->user()->tasks();

        if ($this->filter) {
            $query->where('status', $this->filter);
        }

        $tasks = $query->latest()->paginate(10);

        return view('livewire.list-tasks', [
            'tasks' => $tasks
        ]);
    }
}
