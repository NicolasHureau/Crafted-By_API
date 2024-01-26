<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\City;
use App\Models\Invoice;
use App\Models\User;
use App\Models\Zip_code;
use Database\Factories\Zip_codeFactory;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\UsersController::factory(10)->create();

        // \App\Models\UsersController::factory()->create([
        //     'name' => 'Test UsersController',
        //     'email' => 'test@example.com',
        // ]);

        $this->call([
            SpatieSeeder::class,
            AdminSeeder::class,
            OwnerSeeder::class,
            UserSeeder::class,
            BusinessSeeder::class,
            ProductsSeeder::class,
            StatusSeeder::class,
            InvoicesSeeder::class,
        ]);
    }
}
