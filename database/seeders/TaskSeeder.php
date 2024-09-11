<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Task;
use App\Models\User;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();

        Task::factory()->count(5)->make()->each(function ($task) use ($users) {
            $task->user_id = $users->random()->id;
            $task->save();
        });
    }
}
