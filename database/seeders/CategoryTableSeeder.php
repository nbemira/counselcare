<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategoryTableSeeder extends Seeder
{
    public function run(): void
    {
        Category::create([
            'category_id' => '1',
            'category' => 'Depression',
        ]);

        Category::create([
            'category_id' => '2',
            'category' => 'Anxiety',
        ]);

        Category::create([
            'category_id' => '3',
            'category' => 'Stress',
        ]);
    }
}
