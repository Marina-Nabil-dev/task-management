<?php

use App\Http\Resources\TaskResource;
use App\Models\Task;
use App\Models\User;

use function Pest\Laravel\getJson;

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->tasks = Task::factory(3)->assignToUser($this->user)->create();
});

test('get user tasks successfully', function () {

    $response = getJson("/api/users/{$this->user->id}/tasks");

    $response->assertStatus(200)
        ->assertJson([
            'status' => 200,
            'message' => "User's tasks",
            'data' => TaskResource::collection($this->tasks)->response()->getData(true)['data'],
        ]);
});
test('cannot get tasks for non-existent user', function () {
    $response = getJson('/api/users/999/tasks');
    $response->assertStatus(404);
    $response->assertJson([
        'status' => 404,
        'message' => 'User not found',
    ]);
});
