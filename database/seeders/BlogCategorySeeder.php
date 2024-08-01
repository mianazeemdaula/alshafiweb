<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BlogCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Men Health', 'slug' => 'men-health'],
            ['name' => 'Female Health', 'slug' => 'female-health'],
        ];

        foreach ($categories as $category) {
            \App\Models\BlogCategory::create($category);
        }
    }
}
