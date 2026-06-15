<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Стратегії', 'slug' => 'strategies'],
            ['name' => 'Сімейні', 'slug' => 'family'],
            ['name' => 'Карткові', 'slug' => 'card-games'],
            ['name' => 'Логічні', 'slug' => 'abstract-games']
        ];

        foreach ($categories as $category) {
            Category::firstOrCreate(['slug' => $category['slug']], $category);
        }
    }
}