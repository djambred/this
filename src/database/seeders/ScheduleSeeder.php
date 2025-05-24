<?php

namespace Database\Seeders;

use App\Models\Schedule;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schedule::firstOrcreate([
            'batch_id' => 1,
            'modules_id' => 1,
            'start_time' => '2023-10-01',
            'end_time' => '2023-10-31',
            'location' => 'Online',
            'status' => 'scheduled',
        ]);
    }
}
