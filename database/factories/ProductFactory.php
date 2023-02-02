<?php

namespace Database\Factories;

use App\Models\AttributeValue;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Location;
use App\Models\Year;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $category = Category::doesntHave('child')->inRandomOrder()->first();
        $brand = Brand::inRandomOrder()->first();
        $year = Year::inRandomOrder()->first();
        $location = Location::inRandomOrder()->first();

        $motor = fake()->boolean(90)
            ? AttributeValue::where('attribute_id', 1)->inRandomOrder()->first() : null;

        $nameTm = fake()->streetSuffix();
        $nameEn = null;

        $fullNameTm = $brand->name . ' '
            . $nameTm . ' '
            . (isset($motor) ? $motor->name_tm . ' ' : '')
            . $category->product_name_tm
            . $location->name_tm;
        $fullNameEn = $brand->name . ' '
            . ($nameEn ?: $nameTm) . ' '
            . (isset($motor) ? ($motor->name_en ?: $motor->name_tm) . ' ' : '')
            . $category->product_name_en
            . $location->name_en;
        
        return [
            'category_id' => $category->id,
            'brand_id' => $brand->id,
            'year_id' => $year->id,
            'location_id' => $location->id,
            'motor_id' => isset($motor) ? $motor->id : null,

            'code' => 'c' . $category->id
                . '-b' . $brand->id
                . (isset($motor) ? '-g' . $motor->id : ''),

            'name_tm' => $nameTm,
            'name_en' => $nameEn,
            'full_name_tm' => $fullNameTm,
            'full_name_en' => $fullNameEn,
            'credit' => fake()->boolean(30),
            'swap' => fake()->boolean(30),
            'phone' => rand(60000000, 65999999),
            'slug' => str()->slug($fullNameTm) . '-' . str()->random(10),
            'price' => fake()->randomFloat($nbMaxDecimals = 1, $min = 10, $max = 100),
            'created_at' => fake()->dateTimeBetween('-1 year', 'now')->format('Y-m-d H:i:s'),
            'viewed' => rand(200, 500)
        ];
    }
}
