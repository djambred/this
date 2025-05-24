<?php

namespace Database\Seeders;

use App\Models\Modules;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ModulesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 14; $i++) {
            Modules::firstOrCreate([
                'course_id' => 1,
                'name' => 'Pertemuan '. $i,
                'file' => '',
                'video' => '',
            ]);
        }
    }
}
