<?php

namespace Database\Seeders;

use App\Models\Course;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (Course::count() == 0) {
            Course::create([
                'title' => 'Fullstack Developer',
                'description' => 'Belajar Fullstack Developer',
                'image' => '',
                'link' => 'https://ptjin.co.id',
                'instructor_id' => 2,
            ]);
        }
    }
}
