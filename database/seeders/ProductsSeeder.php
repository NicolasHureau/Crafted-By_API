<?php

namespace Database\Seeders;

use App\Models\Business;
use App\Models\Category;
use App\Models\Color;
use App\Models\Material;
use App\Models\Products;
use App\Models\Size;
use App\Models\Style;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Products::factory()
            ->count(10)
            ->for(Size::factory()->create())
            ->for(Category::factory()->create())
            ->for(Material::factory()->create())
            ->for(Style::factory()->create())
            ->for(Color::factory()->create())
            ->create();
    }
}
