<?php

namespace Database\Factories;

use App\Models\AttributeValue;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Customer;
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

        $fullNameTm = $category->name_tm . ' '
            . (isset($motor) ? 'Motory: ' . $motor->name_tm . ', ' : '')
            . 'Ýeri: ' . $location->name_tm;
        $fullNameEn = $category->name_en . ' '
            . (isset($motor) ? ($motor->name_en ?: $motor->name_tm) . ' ' : '')
            . $location->name_en;
        
        return [
            'category_id' => $category->id,
            'brand_id' => $brand->id,
            'year_id' => $year->id,
            'location_id' => $location->id,
            'motor_id' => isset($motor) ? $motor->id : null,

            'name_tm' => $nameTm,
            'name_en' => $nameEn,
            'full_name_tm' => $fullNameTm,
            'full_name_en' => $fullNameEn,
            'credit' => fake()->boolean(30),
            'description' => fake()->text(500),
            'swap' => fake()->boolean(30),
            'phone' => rand(60000000, 65999999),
            'price' => fake()->randomFloat($nbMaxDecimals = 0, $min = 30000, $max = 50000),
            'created_at' => fake()->dateTimeBetween('-5 month', 'now')->format('Y-m-d H:i:s'),
            'viewed' => rand(200, 500),
        ];
    }
}
