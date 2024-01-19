<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Size>
 */
class SizeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'height' => fake()->randomFloat(1,0,100),
            'width' => fake()->randomFloat(1,0,100),
            'depth' => fake()->randomFloat(1,0,100),
            'capacity' => fake()->randomFloat(1,0,100),
        ];
    }
}
