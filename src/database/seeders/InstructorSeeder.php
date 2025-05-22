<?php

namespace Database\Seeders;

use App\Models\Instructor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InstructorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Instructor::firstOrCreate([
            'user_id' => 2,
            'instructor_id' => 'INS-001',
            'phone' => '1234567890',
            'bio' => 'Experienced instructor with a passion for teaching.',
            'expertise' => 'Web Development, PHP, Laravel',
        ]);
    }
}
