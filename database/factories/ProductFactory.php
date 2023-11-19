<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'price' => fake()->numberBetween(100, 1000),
            'stock' => fake()->numberBetween(1, 100),
            'is_enabled' => fake()->boolean(),
            'created_at' => now(),
            'updated_at' => now(),
            'category_id' => fake()->numberBetween(1, 10),
        ];
    }
}
