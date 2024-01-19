<?php

namespace Database\Factories;

use App\Models\Business;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Factory as Faker;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Products>
 */
class ProductsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $faker = Faker::create('fr_FR');
        $biz = Business::all()->random(1)->value('id');
        return [
            'name' => fake()->word(),
            'business_id' => $biz,
            'description' => $faker->paragraph(),
            'price' => fake()->randomFloat(2,10,300),
            'stock' => fake()->numberBetween(0, 50),
            'image' => fake()->imageUrl(),
            'active' => fake()->boolean(),
        ];
    }
}
