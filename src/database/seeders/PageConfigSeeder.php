<?php

namespace Database\Seeders;

use App\Models\Front\PageConfig;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PageConfigSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (PageConfig::count() == 0) {
            PageConfig::create([
                'logo' => '',
                'title' => 'Innovate. Succeed!',
                'description' => 'Unlocking Potential, Igniting Excellence',
                'name_services' => 'Our Service',
                'description_services' => 'Our Online Services',
                'detail_services' => 'The Best I Ever Had',
                'image' => '',
                'url' => ''
            ]);
        }
    }
}
