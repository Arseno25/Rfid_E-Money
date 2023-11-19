<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class Product extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // \App\Models\Product::factory(10)->create();

        \App\Models\Product::factory()->create([
            'name' => 'Product 1',
            'is_enabled' => 1,
            'price' => 100000,
            'stock' => 10,
            'category_id' => 1,
            ]);
    }
}
