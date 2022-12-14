<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::create([
            'name' => '交換',
        ]);
        Category::create([
            'name' => '譲渡',
        ]);
        Category::create([
            'name' => '交換＆譲渡',
        ]);
        
    }
}
