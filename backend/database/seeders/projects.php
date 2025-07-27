<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class projects extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('projects')->insert([
            [
                'owner_id' => 1,
                'title' => 'Dự án Todo App',
                'description' => 'Ứng dụng quản lý công việc đơn giản.',
                'is_group_project' => false,
                'start_date' => Carbon::create(2025, 7, 1),
                'end_date' => Carbon::create(2025, 7, 31),
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
