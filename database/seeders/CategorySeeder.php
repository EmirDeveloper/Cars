<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $objs = [
            ['Mercedes', null, null, null],
            ['BMW', null, null, null],
            ['KIA', null, null, null],
            ['AUDI', null, null, null],
            ['Volswagen', null, null, null],
            ['Tayota', null, null, null],
            ['Nissan', null, null, null],
            ['Lexus', null, null, null]
        ];

        for ($i=0; $i < count($objs); $i++) {
            Category::create([
                'name_tm' => $objs[$i][0],
                'name_en' => $objs[$i][1],
                'product_name_tm' => $objs[$i][2],
                'product_name_en' => $objs[$i][3],
                'sort_order' => $i + 1
            ]);
        }
    }
}
