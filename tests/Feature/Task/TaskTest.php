<?php


use App\Enums\TaskStatusEnum;
use App\Models\Task;
use function Pest\Laravel\{deleteJson, getJson, postJson, patchJson};

beforeEach(function () {
    $this->task = Task::factory()->create();
});

test('can get all tasks', function () {
    Task::factory()->count(104)->create();

    getJson('/api/tasks')
        ->assertOk()->assertJson([
            'message' => 'Tasks fetched successfully',
        ]);
});

test('can filter tasks by status', function () {
    Task::factory()->count(2)->create(['status' => TaskStatusEnum::NEW]);
    Task::factory()->count(3)->create(['status' => TaskStatusEnum::IN_PROGRESS]);

    $newTasksCount = Task::whereStatus(TaskStatusEnum::NEW)->count();

    getJson('/api/tasks?status='.TaskStatusEnum::NEW->value)
        ->assertOk()
        ->assertJsonCount($newTasksCount, 'data');
});

test('can filter tasks by date range', function () {
    Task::factory()->create(['due_date' => now()->subDays(20)]);
    Task::factory()->create(['due_date' => now()]);
    Task::factory()->create(['due_date' => now()->addDays(20)]);

    $tasksCount = Task::whereBetween('due_date', [
        now()->subDay()->format('Y-m-d'),
        now()->addDays(21)->format('Y-m-d')
    ])->count();


    getJson('/api/tasks?date_from='.now()->subDay()->format('Y-m-d').'&date_to='.now()->addDays(21)->format('Y-m-d'))
        ->assertOk()
        ->assertJsonCount($tasksCount, 'data');
});

test('can create a task', function () {
    $taskData = [
        'title' => 'Test Task',
        'description' => 'Test Description',
        'due_date' => now()->addDay()->format('Y-m-d'),
    ];

    postJson('/api/tasks', $taskData)
        ->assertOk()
        ->assertJson([
            'code' => 200,
            'message' => 'Task created successfully'
        ]);

    $this->assertDatabaseHas('tasks', [
        ...$taskData,
        'status' => TaskStatusEnum::NEW
    ]);
});

test('can update a task', function () {
    $updatedData = [
        'title' => 'Title Updated',
        'description' => 'Description Updated',
        'status' => TaskStatusEnum::IN_PROGRESS
    ];

    patchJson('/api/tasks/'.$this->task->slug, $updatedData)
        ->assertOk()
        ->assertJson([
            'code' => 200,
            'message' => 'Updated successfully'
        ]);

    $this->assertDatabaseHas('tasks', [
        'id' => $this->task->id,
        ...$updatedData
    ]);
});

test('can delete a task', function () {
    deleteJson('/api/tasks/'.$this->task->slug)
        ->assertOk()
        ->assertJson([
            'code'  => 200,
            'message' => 'Task deleted successfully'
        ]);

    $this->assertDatabaseMissing('tasks', [
        'id' => $this->task->id,
        'deleted_at' => null
    ]);
});
