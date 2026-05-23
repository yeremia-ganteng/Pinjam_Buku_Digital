<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Str; // Import ini!
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Buat User
        \App\Models\User::updateOrCreate(
            ['email' => 'admin@mail.com'],
            [
                'name' => 'Admin Perpustakaan', 
                'password' => Hash::make('password'), 
                'role' => 'admin'
            ]
        );

        // 2. Buat Kategori dengan SLUG otomatis
        $categories = ['Fiksi', 'Bisnis', 'Teknologi', 'Sejarah'];
        
        foreach ($categories as $cat) {
            Category::updateOrCreate(
                ['name' => $cat],
                ['slug' => Str::slug($cat)] // Ini kuncinya!
            );
        }

        // 3. Panggil BookSeeder
        $this->call([
            BookSeeder::class,
        ]);
    }
}