<?php

namespace Database\Seeders;

use App\Models\Student;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Student::firstOrCreate([
            'user_id' => 3,
            'student_id' => 'STU-001',
            'student_origin' => 'kj',
            'phone' => '1234567890',
            'address' => '123 Main St, City, Country',
            'github_name' => 'student-github',
            'github_url' => 'https://github.com/student-github',
        ]);
    }
}
