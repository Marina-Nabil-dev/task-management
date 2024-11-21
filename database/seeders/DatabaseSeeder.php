<?php

namespace Database\Seeders;

use App\Models\Task;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $email = $this->command->ask('Please Enter Your Email', 'default@example.com');
        $this->command->info('Your Email: ' . $email);
        $this->command->info('Your Password: ' . 'password');

        User::factory()->create([
            'name' => 'Admin',
            'email' => $email,
            'password' => Hash::make('password'),
        ]);

        User::factory(10)->create([
            'password' => Hash::make('password'),
        ]);

        Task::factory(20)
            ->create();
    }
}
