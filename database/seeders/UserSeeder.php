<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\User;
use App\Models\Zip_code;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()
            ->count(3)
            ->for(Zip_code::factory()->create())
            ->for(City::factory()->create())
            ->create();

    }
}
