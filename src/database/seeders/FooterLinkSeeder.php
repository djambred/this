<?php

namespace Database\Seeders;

use App\Models\Front\FooterLink;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FooterLinkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (FooterLink::count() == 0) {
            FooterLink::create([
                'section' => 'service',
                'label' => 'Digital Marketing',
                'url' => 'service-details.html',
                'order' => 1,
            ]);
        }
    }
}
