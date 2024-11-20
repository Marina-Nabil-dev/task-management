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

    //    public function configure(): static
    //    {
    //        return $this->afterCreating(function (Task $task) {
    //            $task->users()->sync(User::inRandomOrder()->take(3)->pluck('id'));
    //        });
    //    }

    public function definition(): array
    {
        $title = $this->faker->unique()->word();

        return [
            'title' => $title,
            'slug' => Str::slug($title),
            'description' => $this->faker->text(),
            'due_date' => $this->faker->dateTimeBetween('-2 month', '+2 month')->format('Y-m-d'),
            'status' => $this->faker->randomElement(TaskStatusEnum::values()),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}