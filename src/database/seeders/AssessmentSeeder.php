<?php

namespace Database\Seeders;

use App\Models\Assessment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AssessmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Assessment::firstOrCreate([
            'github_repository' => 'bootcamp',
            'score' => '0',
            'status' => 'ongoing',
            'user_id' => 3,
            'modules_id' => 1,
        ]);
    }
}
