<?php

namespace App\Livewire;

use App\Enums\TaskStatusEnum;
use App\Models\Task;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithPagination;

class ListTasks extends Component
{
    use WithPagination;

    #[Computed]
    public $filter = '';

    public $showModal = false;

    #[Validate('required|min:8')]
    public $title = '';
    #[Validate('sometimes|string')]
    public $description = '';

    protected $listeners = ['taskUpdated' => '$refresh', 'taskCreated' => '$refresh'];

    protected $rules = [
        'title' => 'required|min:3',
        'description' => 'sometimes|string'
    ];

    public function updateTaskStatus($taskId)
    {
        $task = Task::find($taskId);
        if ($task && $task->user_id === auth()->id()) {
            $task->status = $task->status === TaskStatusEnum::COMPLETED->value
                ? TaskStatusEnum::PENDING->value
                : TaskStatusEnum::COMPLETED->value;
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

        $query->when($this->filter, function ($query)
        {
        return $query->where('status', $this->filter);
        });

        $tasks = $query->latest()->paginate(10);

        return view('livewire.list-tasks', [
            'tasks' => $tasks
        ]);
    }

    public function saveTask()
    {
        $this->validate();

        auth()->user()->tasks()->create([
            'title' => $this->title,
            'description' => $this->description ?? null,
            'status' => TaskStatusEnum::PENDING->value
        ]);

        $this->reset(['showModal', 'title', 'description']);
        session()->flash('message', 'Task created successfully!');
        $this->dispatch('taskCreated');
    }

    public function closeModal()
    {
        $this->reset(['showModal', 'title', 'description']);
        $this->resetValidation();
    }
}
