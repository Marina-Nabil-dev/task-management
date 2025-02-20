<?php

namespace Database\Seeders;

use App\Models\Task;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(10)->create([
            'password' => Hash::make('password'),
        ]);

        User::factory()->user()->create([
            'password' => Hash::make('password'),
        ]);

        $this->call(RoleSeeder::class);

        User::factory()->admin()->create([
           'password' => Hash::make('123456789'),
           'email' => "admin@system.com"
        ]);

        Task::factory(20)
            ->create();
    }
}
