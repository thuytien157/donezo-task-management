<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class tasks extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tasks')->insert([
            [
                'project_id' => 1,
                'created_by' => 1,
                'title' => 'Thiết kế UI',
                'description' => 'Lên layout giao diện chính.',
                'status' => 'Phân tích',
                'deadline' => now()->addDays(7),
            ]
        ]);
    }
}
