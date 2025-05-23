<?php

namespace Database\Seeders;

use App\Models\Front\Jargon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JargonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (Jargon::count() == 0) {
        Jargon::create([
            'slogan' => 'Maju Terus Pantang Mundur @ 2025'
        ]);
        }
    }
}
