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
            'name' => 'Pertemuan 1',
            'description' => '',
            'bootcamp_id' => 1,
        ]);
    }
}
