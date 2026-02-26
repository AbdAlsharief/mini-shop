<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    public function run(): void
    {
        $tags = [
            ['name' => 'Gaming',     'slug' => 'gaming'],
            ['name' => 'Wireless',   'slug' => 'wireless'],
            ['name' => 'Mechanical', 'slug' => 'mechanical'],
            ['name' => '4K',         'slug' => '4k'],
            ['name' => 'Budget',     'slug' => 'budget'],
            ['name' => 'Premium',    'slug' => 'premium'],
        ];

        foreach ($tags as $tag) {
            Tag::firstOrCreate(['slug' => $tag['slug']], $tag);
        }
    }
}
