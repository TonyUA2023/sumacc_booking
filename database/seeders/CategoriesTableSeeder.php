<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategoriesTableSeeder extends Seeder
{
    public function run()
    {
        $categories = [
            ['name' => 'Mobile Detailing', 'description' => '']
            // Añade aquí más categorías si lo deseas.
        ];

        foreach ($categories as $cat) {
            Category::firstOrCreate(['name' => $cat['name']], [
                'description' => $cat['description']
            ]);
        }
    }
}