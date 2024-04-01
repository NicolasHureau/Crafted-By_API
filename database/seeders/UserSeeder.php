<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\User;
use App\Models\Zip_code;
use Database\Factories\AdminFactory;
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
            ->customer()
//            ->for(Zip_code::factory()->create())
//            ->for(City::factory()->create())
            ->create();
    }
}
