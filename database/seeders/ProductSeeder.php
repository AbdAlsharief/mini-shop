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
        Product::create(['name' => 'Laptop', 'description' => 'Gaming laptop', 'price' => 1200, 'stock' => 5]);
        Product::create(['name' => 'Phone', 'description' => 'Smart phone', 'price' => 800, 'stock' => 10]);
        Product::create(['name' => 'Headphones', 'description' => 'Wireless headphones', 'price' => 150, 'stock' => 20]);
        Product::create(['name' => 'Keyboard', 'description' => 'Mechanical keyboard', 'price' => 120, 'stock' => 15]);
        Product::create(['name' => 'Mouse', 'description' => 'Gaming mouse', 'price' => 60, 'stock' => 25]);
        Product::create(['name' => 'Monitor', 'description' => '4K monitor', 'price' => 400, 'stock' => 8]);
    }
}
