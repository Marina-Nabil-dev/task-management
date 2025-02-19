@livewireStyles

<div class="max-w-4xl mx-auto px-4 py-6">
    <div class="mb-6 flex flex-wrap gap-3">
        <button wire:click="$set('filter', '')"
                class="px-4 py-2 rounded-lg {{ $filter === '' ? 'bg-blue-600 text-white' : 'bg-gray-200 hover:bg-gray-300' }}">
            All Tasks
        </button>
        <button wire:click="$set('filter', 'pending')"
                class="px-4 py-2 rounded-lg {{ $filter === 'pending' ? 'bg-blue-600 text-white' : 'bg-gray-200 hover:bg-gray-300' }}">
            Pending
        </button>
        <button wire:click="$set('filter', 'completed')"
                class="px-4 py-2 rounded-lg {{ $filter === 'completed' ? 'bg-blue-600 text-white' : 'bg-gray-200 hover:bg-gray-300' }}">
            Completed
        </button>
    </div>

    <div class="space-y-4">
        @forelse ($tasks as $task)
            <div class="bg-white rounded-lg shadow p-4 hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between flex-wrap gap-4">
                    <div class="flex-1">
                        <h3 class="text-lg font-semibold {{ $task->status === 'completed' ? 'line-through text-gray-500' : '' }}">
                            {{ $task->title }}
                        </h3>
                        @if($task->description)
                            <p class="mt-2 text-gray-600">{{ $task->description }}</p>
                        @endif
                    </div>
                    <div class="flex items-center gap-2">
                        <button wire:click="updateTaskStatus({{ $task->id }})"
                                class="px-3 py-1 rounded-lg {{ $task->status === 'completed' ? 'bg-green-500' : 'bg-yellow-500' }} text-white hover:opacity-75">
                            {{ $task->status === 'completed' ? 'Completed' : 'Mark Complete' }}
                        </button>
                        <button wire:click="deleteTask({{ $task->id }})"
                                class="px-3 py-1 rounded-lg bg-red-500 text-white hover:opacity-75">
                            Delete
                        </button>
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center py-8 text-gray-500">
                No tasks found. Create your first task!
            </div>
        @endforelse
    </div>

    <div class="mt-6">
        {{ $tasks->links() }}
    </div>
</div>
@livewireScripts

