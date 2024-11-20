<?php

use App\Models\Task;
use App\Models\User;

use function Pest\Laravel\post;

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->task = Task::factory()->create();
});

test('can assign task to user', function () {
    $response = post(route('assign.task', $this->task), [
        'email' => $this->user->email,
    ]);

    $response->assertStatus(200)
        ->assertJson([
            'message' => 'Task assigned successfully',
        ]);

    expect($this->user->tasks)->toHaveCount(1)
        ->and($this->user->tasks->first()->id)->toBe($this->task->id);
});

test('cannot assign task with invalid email', function () {
    $response = post(route('assign.task', $this->task), [
        'email' => 'invalid-email',
    ]);

    $response->assertUnprocessable()
        ->assertJsonValidationErrors(['email']);
});

test('cannot assign task with non-existent email', function () {
    $response = post(route('assign.task', $this->task), [
        'email' => 'nonexistent@example.com',
    ]);

    $response->assertStatus(422)
        ->assertJsonValidationErrors(['email']);
});

test('cannot assign task without email', function () {
    $response = post(route('assign.task', $this->task), []);

    $response->assertStatus(422)
        ->assertJsonValidationErrors(['email']);
});
