<?php

namespace Database\Factories;

use App\Models\City;
use App\Models\User;
use App\Models\Zip_code;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    public function admin()
    {
        return $this->state(fn (array $attributes) => [
            'lastname' => 'Strikwerda',
            'firstname' => 'Ezra',
            'email' => 'admin@admin.admin',
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
            'address' => 'papeteries',
            'zip_code_id' => Zip_code::factory()->create()->id,
            'city_id' => City::factory()->create()->id,
        ])->afterCreating(function (User $user) {
                $user->assignRole('admin');
            });

    }

    public function owner()
    {
        return $this->state(fn (array $attributes) => [
            'lastname' => 'Hureau',
            'firstname' => 'Nicolas',
            'email' => 'owner@owner.owner',
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
            'address' => 'papeteries',
            'zip_code_id' => Zip_code::factory()->create()->id,
            'city_id' => City::factory()->create()->id,
        ])->afterCreating(function (User $user) {
                $user->assignRole('owner');
            });
    }

    public function customer()
    {
        return $this->state(fn (array $attributes) => [
            'password' => static::$password ??= Hash::make('password'),
            'zip_code_id' => Zip_code::factory()->create()->id,
            'city_id' => City::factory()->create()->id,
        ])->afterCreating(function (User $user) {
            $user->assignRole('customer');
        });
    }

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $faker = Faker::create('fr_FR');
        return [
            'id' => Str::uuid(),
            'lastname' => $faker->lastname(),
            'firstname' => $faker->firstName(),
            'email' => $faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
            'address' => $faker->streetAddress(),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
