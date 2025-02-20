<?php

namespace Database\Factories;

use App\Enums\TaskStatusEnum;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class TaskFactory extends Factory
{
    protected $model = Task::class;

    public function definition(): array
    {
        $title = $this->faker->unique()->word();

        return [
            'title' => $title,
            'slug' => Str::slug($title),
            'description' => $this->faker->text(),
            'due_date' => $this->faker->dateTimeBetween('-2 month', '+2 month')->format('Y-m-d'),
            'status' => $this->faker->randomElement(TaskStatusEnum::values()),
            'user_id'=> User::inRandomOrder()->first()->id,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }

    public function assignToUser(User $user)
    {
        return $this->state(function () use ($user) {
            return $this->afterCreating(function (Task $task) use ($user) {
                $task->users()->attach($user->id);
            });
        });
    }

    public function assignToUsers()
    {
        return $this->state(function () {
            return $this->afterCreating(function (Task $task) {
                $userIds = User::factory(5)->create()->take(3)->pluck('id');
                $task->users()->sync($userIds);
            });
        });
    }
}
