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
        Product::create([
            'name' => 'Laptop',
            'description' => 'Gaming laptop',
            'price' => 1200,
            'stock' => 5
        ]);

        Product::create([
            'name' => 'Phone',
            'description' => 'Smart phone',
            'price' => 800,
            'stock' => 10
        ]);
    }
}
