<?php

namespace Database\Seeders;

use App\Models\Batch;
use App\Models\Bootcamp;
use App\Models\Modules;
use App\Models\Course;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ModulesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $batch = Batch::firstOrCreate([
            'id' => 1,
        ], [
            'name' => 'Batch 1',
        ]);


        $course = Course::firstOrCreate([
            'id' => 1,
        ], [
            'title' => 'Basic Laravel',
            'description' => 'Intro to Laravel Framework',
        ]);

        // Ensure instructor exists (assuming role is already assigned)
        $instructor = User::firstOrCreate([
            'id' => 2,
        ], [
            'name' => 'Jefry Sunupurwa Asri',
            'email' => 'instructor@admin.com',
            'password' => bcrypt('password'),
        ]);

        // Ensure bootcamp exists
        $bootcamp = Bootcamp::firstOrCreate([
            'id' => 1,
        ], [
            'batch_id' => $batch->id,
            'course_id' => $course->id,
        ]);

        // Create modules
        for ($i = 1; $i <= 14; $i++) {
            Modules::firstOrCreate([
                'name' => 'Pertemuan ' . $i,
                'course_id' => $course->id,
                'instructor_id' => $instructor->id,
                'bootcamp_id' => $bootcamp->id,
            ], [
                'video' => '',
                'file' => '',
            ]);
        }
    }
}
