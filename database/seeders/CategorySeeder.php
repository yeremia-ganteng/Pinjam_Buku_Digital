<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            ['name' => 'Fiksi', 'slug' => 'fiksi'],
            ['name' => 'Bisnis', 'slug' => 'bisnis'],
            ['name' => 'Teknologi', 'slug' => 'teknologi'],
            ['name' => 'Sejarah', 'slug' => 'sejarah'],
        ];

        foreach ($categories as $cat) {
            Category::firstOrCreate(['slug' => $cat['slug']], $cat);
        }
    }
}

