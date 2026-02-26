<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Electronics',  'slug' => 'electronics'],
            ['name' => 'Peripherals',  'slug' => 'peripherals'],
            ['name' => 'Audio',        'slug' => 'audio'],
            ['name' => 'Accessories',  'slug' => 'accessories'],
            ['name' => 'Monitors',     'slug' => 'monitors'],
        ];

        foreach ($categories as $category) {
            Category::firstOrCreate(['slug' => $category['slug']], $category);
        }
    }
}
