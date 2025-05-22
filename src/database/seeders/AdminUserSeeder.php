<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::firstOrCreate(
            ['email' => 'admin@admin.com'],
            ['name' => 'Super Admin', 'password' => Hash::make('password')]
        );
        $user->assignRole('super_admin');

        $instructor = User::firstOrCreate(
            ['email' => 'instructor@admin.com'],
            ['name' => 'Instructor', 'password' => Hash::make('password')]
        );
        $instructor->assignRole('instructor');

        $student = User::firstOrCreate(
            ['email' => 'student@admin.com'],
            ['name' => 'Student', 'password' => Hash::make('password')]
        );
        $student->assignRole('student');
    }
}
