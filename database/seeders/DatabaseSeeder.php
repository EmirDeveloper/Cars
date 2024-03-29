<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Customer;
use App\Models\CustomerAddress;
use App\Models\Product;
use App\Models\Verification;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UserSeeder::class,
            CategorySeeder::class,
            BrandSeeder::class,
            AttributeValueSeeder::class,
            LocationSeeder::class,
            YearSeeder::class,
        ]);

        Product::factory()->count(500)->create();

        for ($i = 0; $i < 50; $i++) {
            $verification = Verification::factory()->create();
            if ($verification->status) {
                Customer::factory()
                    ->has(CustomerAddress::factory()->count(rand(1, 2)), 'addresses')
                    ->create([
                        'username' => $verification->phone,
                        'password' => bcrypt($verification->code),
                        'created_at' => $verification->created_at,
                        'updated_at' => $verification->updated_at,
                    ]);
            }
        }
    }
}
