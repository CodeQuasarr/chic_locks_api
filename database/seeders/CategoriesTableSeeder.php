<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Perruques', 'slug' => 'perruques', 'image' => 'https://images.unsplash.com/photo-1580618672591-eb180b1a973f?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80'],
            ['name' => 'Soins', 'slug' => 'soins', 'image' => 'https://images.unsplash.com/photo-1608571423902-eed4a5ad8108?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80'],
            ['name' => 'Accessoires', 'slug' => 'accessoires', 'image' => 'https://images.unsplash.com/photo-1590159763121-7c9fd312190d?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80']
        ];

        foreach ($categories as $category) {
            \App\Models\Category::create([
                'name' => $category['name'],
                'image' => $category['image'],
                'slug' => $category['slug'],
            ]);
        }
    }
}
