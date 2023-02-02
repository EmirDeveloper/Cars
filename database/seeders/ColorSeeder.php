<?php

namespace Database\Seeders;

use App\Models\Color;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ColorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $objs = [
            ['name_tm' => 'Ak', 'name_en' => 'White'],
            ['name_tm' => 'Gara', 'name_en' => 'Black'],
            ['name_tm' => 'Sary', 'name_en' => 'Yellow'],
            ['name_tm' => 'Gök', 'name_en' => 'Blue'],
            ['name_tm' => 'Ýaşyl', 'name_en' => 'Green'],
        ];

        for ($i=0; $i < count($objs); $i++) {
            Color::create([
                'name_tm' => $objs[$i]['name_tm'],
                'name_en' => $objs[$i]['name_en'],
                'sort_order' => $i + 1
            ]);
        }
    }
}
