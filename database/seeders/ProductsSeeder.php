<?php

namespace Database\Seeders;

use App\Models\Business;
use App\Models\Category;
use App\Models\Color;
use App\Models\Material;
use App\Models\Product;
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
        $size = Size::factory()->count(10)->create();
        $category = Category::factory()->count(10)->create();
        $material = Material::factory()->count(10)->create();
        $style = Style::factory()->count(10)->create();
        $color = Color::factory()->count(10)->create();

        $counter = 0;
        $numberOfProducts = 30;

        while ($counter < $numberOfProducts)
        {
            Product::factory()
                ->count(3)
                ->for($size->shift())
                ->for($category->shift())
                ->for($material->shift())
                ->for($style->shift())
                ->for($color->shift())
                ->create();

            $counter += 3;
        }

    }
}
