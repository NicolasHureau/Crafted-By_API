<?php

namespace Database\Seeders;

use App\Models\Business;
use App\Models\City;
use App\Models\Speciality;
use App\Models\Theme;
use App\Models\User;
use App\Models\Zip_code;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Random\RandomException;

class BusinessSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * @throws RandomException
     */
    public function run(): void
    {
        Business::factory()
            ->count(3)
            ->has(Speciality::factory()->count(random_int(1,3)))
            ->for(Zip_code::factory()->create())
            ->for(City::factory()->create())
            ->for(Theme::factory()->create())
            ->create();

        Business::all()->each(function ($biz) {
            $biz->owner()->attach(User::all()->random(rand(1,2))->pluck('id'));
        });
    }
}
