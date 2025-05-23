<?php

namespace Database\Seeders;

use App\Models\Front\Seo;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SeoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (Seo::count() == 0) {
            Seo::create([
                'title' => 'BOOTCAMP',
                'description' => 'Bootcamp Esa Unggul is a digital bootcamp that provides training in web development, data science, and digital marketing.',
                'keywords' => 'web development, Laravel, services, portfolio, digital agency',
                'canonical_url' => 'https://www.pemweb.com',
                'robots' => 'index, follow',
                'og_image' => '', // You can put a default image path
            ]);
        }
    }
}
