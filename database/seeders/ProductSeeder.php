<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\Tag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $electronics  = Category::where('slug', 'electronics')->first();
        $peripherals  = Category::where('slug', 'peripherals')->first();
        $audio        = Category::where('slug', 'audio')->first();
        $monitors     = Category::where('slug', 'monitors')->first();

        $gaming    = Tag::where('slug', 'gaming')->first();
        $wireless  = Tag::where('slug', 'wireless')->first();
        $mechanical= Tag::where('slug', 'mechanical')->first();
        $tag4k     = Tag::where('slug', '4k')->first();
        $budget    = Tag::where('slug', 'budget')->first();
        $premium   = Tag::where('slug', 'premium')->first();

        $products = [
            [
                'data'  => ['name' => 'Laptop',      'description' => 'High-performance gaming laptop with RTX 4070.',   'price' => 1200, 'stock' => 5,  'category_id' => $electronics?->id],
                'tags'  => [$gaming, $premium],
            ],
            [
                'data'  => ['name' => 'Phone',        'description' => 'Flagship smartphone with AMOLED display.',         'price' => 800,  'stock' => 10, 'category_id' => $electronics?->id],
                'tags'  => [$wireless, $premium],
            ],
            [
                'data'  => ['name' => 'Headphones',   'description' => 'Over-ear wireless headphones with ANC.',           'price' => 150,  'stock' => 20, 'category_id' => $audio?->id],
                'tags'  => [$wireless, $gaming],
            ],
            [
                'data'  => ['name' => 'Keyboard',     'description' => 'Compact TKL mechanical keyboard, blue switches.',  'price' => 120,  'stock' => 15, 'category_id' => $peripherals?->id],
                'tags'  => [$mechanical, $gaming],
            ],
            [
                'data'  => ['name' => 'Mouse',        'description' => 'Lightweight gaming mouse, 16K DPI sensor.',        'price' => 60,   'stock' => 25, 'category_id' => $peripherals?->id],
                'tags'  => [$gaming, $budget],
            ],
            [
                'data'  => ['name' => 'Monitor',      'description' => '27-inch 4K IPS display, 144 Hz refresh rate.',    'price' => 400,  'stock' => 8,  'category_id' => $monitors?->id],
                'tags'  => [$tag4k, $premium],
            ],
            [
                'data'  => ['name' => 'Earbuds',      'description' => 'True wireless earbuds with 30-hour battery.',     'price' => 80,   'stock' => 30, 'category_id' => $audio?->id],
                'tags'  => [$wireless, $budget],
            ],
            [
                'data'  => ['name' => 'Webcam',       'description' => '4K USB webcam for streaming and video calls.',    'price' => 90,   'stock' => 12, 'category_id' => $peripherals?->id],
                'tags'  => [$tag4k],
            ],
            [
                'data'  => ['name' => 'Gaming Chair',  'description' => 'Ergonomic gaming chair with lumbar support.',    'price' => 250,  'stock' => 6,  'category_id' => null],
                'tags'  => [$gaming, $premium],
            ],
            [
                'data'  => ['name' => 'USB Hub',       'description' => '7-port USB 3.0 hub with power delivery.',        'price' => 35,   'stock' => 40, 'category_id' => $peripherals?->id],
                'tags'  => [$budget],
            ],
        ];

        foreach ($products as $item) {
            $product = Product::create($item['data']);
            $tagIds  = collect($item['tags'])->filter()->pluck('id')->toArray();
            $product->tags()->sync($tagIds);
        }
    }
}
