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
            ['Ulaglar', 'Cars', [
                ['Mercedes', null, null, null],
                ['BMW', null, null, null],
                ['KIA', null, null, null],
                ['AUDI', null, null, null],
                ['Volswagen', null, null, null],
                ['Tayota', null, null, null],
                ['Nissan', null, null, null],
                ['Lexus', null, null, null]
            ]],
            ['Awtoşaýlar', 'Cars', [
                ['Mercedes Awtoşaýlar', null, null, null],
                ['BMW Awtoşaýlar', null, null, null],
                ['KIA Awtoşaýlar', null, null, null],
                ['AUDI Awtoşaýlar', null, null, null],
                ['Volswagen Awtoşaýlar', null, null, null],
                ['Tayota Awtoşaýlar', null, null, null],
                ['Nissan Awtoşaýlar', null, null, null],
                ['Lexus Awtoşaýlar', null, null, null]
            ]],
        ];

        for ($i=0; $i < count($objs); $i++) {
            $category = Category::create([
                'name_tm' => $objs[$i][0],
                'name_en' => $objs[$i][1],
                'sort_order' => $i + 1
            ]);
            
            for ($j=0; $j < count($objs[$i][2]); $j++) {
                Category::create([
                    'parent_id' => $category->id,
                    'name_tm' => $objs[$i][2][$j][0],
                    'name_en' => $objs[$i][2][$j][1],
                    'product_name_tm' => $objs[$i][2][$j][2],
                    'product_name_en' => $objs[$i][2][$j][3],
                    'sort_order' => $j + 1
                ]);
            }
        }
    }
}
