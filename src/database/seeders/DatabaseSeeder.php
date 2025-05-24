<?php

namespace Database\Seeders;

use App\Models\Assessment;
use App\Models\Product;
use App\Models\User;
use GuzzleHttp\Handler\Proxy;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            AdminUserSeeder::class,
            InstructorSeeder::class,
            StudentSeeder::class,
            CourseSeeder::class,
            JargonSeeder::class,
            LogoSeeder::class,
            FooterLinkSeeder::class,
            SeoSeeder::class,
            PageConfigSeeder::class,
            ModulesSeeder::class,
            BatchSeeder::class,
            AssessmentSeeder::class,
            ScheduleSeeder::class,
            ProductSeeder::class,
        ]);
    }
}
