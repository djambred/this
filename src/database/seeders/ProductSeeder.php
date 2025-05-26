<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::firstOrCreate([
            'batch_id' => 1,
            'course_id' => 1,
            'user_id' => 2,
            'price' => 100.00,
            'image' => '',
        ]);
    }
}
