<div class="max-w-4xl mx-auto px-4 py-6">
    <div class="mb-6">
        <button wire:click="$set('showModal', true)"
                class="flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Add New Task
        </button>
    </div>

    @if (session()->has('message'))
        <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">{{ session('message') }}</span>
        </div>
    @endif

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

    <!-- Tasks List -->
    <div class="space-y-4">
        @forelse ($tasks as $task)
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <button wire:click="updateTaskStatus({{ $task->id }})" class="flex-shrink-0">
                            @if($task->status === \App\Enums\TaskStatusEnum::COMPLETED)
                                <svg class="w-6 h-6 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                          d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                          clip-rule="evenodd"/>
                                </svg>
                            @else
                                <div class="relative">
                                    <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor"
                                         viewBox="0 0 24 24">
                                        <circle cx="12" cy="12" r="10" stroke-width="2"/>
                                    </svg>
                                    <!-- Tooltip -->
                                    <div
                                        class="absolute left-1/2 -translate-x-1/2 bottom-full mb-2 hidden group-hover:block w-auto">
                                        <div
                                            class="bg-gray-800 text-white text-sm rounded-md px-3 py-1.5 whitespace-nowrap">
                                            Click to mark as complete
                                            <!-- Tooltip arrow -->
                                            <div class="absolute left-1/2 -translate-x-1/2 top-full">
                                                <div class="border-4 border-transparent border-t-gray-800"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </button>
                        <div class="flex-1">
                            <h3 class="text-lg font-semibold {{ $task->status === \App\Enums\TaskStatusEnum::COMPLETED? 'line-through text-gray-500' : 'text-gray-900' }}">
                                {{ $task->title }}
                            </h3>
                            @if($task->description)
                                <p class="mt-1 text-gray-600">{{ $task->description }}</p>
                            @endif
                        </div>
                    </div>
                    <button wire:click="deleteTask({{ $task->id }})"
                            class="text-red-600 hover:text-red-800"
                            onclick="return confirm('Are you sure you want to delete this task?')">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                    </button>
                </div>
            </div>
        @empty
            <div class="text-center py-8 text-gray-500">
                No tasks found. Create your first task!
            </div>
        @endforelse

        <div class="mt-6">
            {{ $tasks->links() }}
        </div>
    </div>

    @if($showModal)
        <div class="relative z-10" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

            <div class="fixed inset-0 z-10 overflow-y-auto">
                <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                    <div
                        class="relative transform overflow-hidden rounded-lg bg-white px-4 pb-4 pt-5 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg sm:p-6">
                        <div class="absolute right-0 top-0 pr-4 pt-4">
                            <button wire:click="closeModal"
                                    class="rounded-md bg-white text-gray-400 hover:text-gray-500 focus:outline-none">
                                <span class="sr-only">Close</span>
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                     stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </div>

                        <div class="sm:flex sm:items-start">
                            <div class="mt-3 text-center sm:mt-0 sm:text-left w-full">
                                <h3 class="text-lg font-semibold leading-6 text-gray-900" id="modal-title">
                                    Add New Task
                                </h3>

                                <form wire:submit.prevent="saveTask" class="mt-4 space-y-4">
                                    <div>
                                        <label for="title" class="block text-sm font-medium text-gray-700">
                                            Title
                                            <span class="text-red-500">*</span>
                                        </label>
                                        <input type="text" wire:model="title" id="title"
                                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                                               placeholder="Enter task title">
                                        @error('title')
                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="description" class="block text-sm font-medium text-gray-700">
                                            Description
                                        </label>
                                        <textarea wire:model="description" id="description" rows="3"
                                                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                                                  placeholder="Enter task description (optional)"></textarea>
                                        @error('description')
                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="mt-5 sm:mt-4 sm:flex sm:flex-row-reverse">
                                        <button type="submit"
                                                class="inline-flex w-full justify-center rounded-md bg-blue-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-500 sm:ml-3 sm:w-auto">
                                            Save Task
                                        </button>
                                        <button type="button" wire:click="closeModal"
                                                class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto">
                                            Cancel
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

