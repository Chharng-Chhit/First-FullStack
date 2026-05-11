<?php

namespace Database\Seeders;

use App\Models\Task;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        Task::create([
            'title' => 'Learn full stack concept',
            'description' => 'Understand frontend, backend, API, and database flow.',
            'status' => 'completed',
            'priority' => 'high',
        ]);

        Task::create([
            'title' => 'Build Laravel API',
            'description' => 'Create migration, model, controller, and route.',
            'status' => 'pending',
            'priority' => 'high',
        ]);

        Task::create([
            'title' => 'Connect Vue.js with Axios',
            'description' => 'Call Laravel API from Vue frontend.',
            'status' => 'pending',
            'priority' => 'medium',
        ]);
    }
}
