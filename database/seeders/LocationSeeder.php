<?php

namespace Database\Seeders;

use App\Models\Location;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $objs = [
            ['Aşgabat', 'Ashgabat', [
                ['Arzuw', null, 15],
                ['Atatürk köç', 'Ataturk street', 15],
                ['Arçabil şaýoly', 'Archabil shayoly', 15],
                ['Bagyr', null, 15],
                ['Berzeňňi', 'Berzenni', 15],
                ['Bekrewe', null, 15],
                ['Bedew', null, 15],
                ['Bitarap türkmenistan şaýoly (Podwoýski köçe)', 'Bitarap turkmenistan shayoly (Podwoyski street)', 15],
                ['Büzmeýin', 'Buzmeyin', 15],
                ['Büzmeýin GRES', 'Buzmeyin GRES', 15],
                ['Çandybil şaýoly', 'Chandybil shayoly', 15],
                ['1 mkr', null, 15],
                ['2 mkr', null, 15],
                ['3 mkr', null, 15],
                ['4 mkr', null, 15],
                ['5 mkr', null, 15],
                ['6 mkr', null, 15],
                ['7 mkr', null, 15],
                ['8 mkr', null, 15],
                ['9 mkr', null, 15],
                ['10 mkr', null, 15],
                ['11 mkr', null, 15],
                ['30 mkr', null, 15],
                ['Howdan "A"', null, 15],
                ['Howdan "B"', null, 15],
                ['Howdan "W"', null, 15],
                ['Türkmenbaşy şaýoly', 'Turkmenbashy shayoly', 15],
                ['Aýtakow (Oguzhan köç)', 'Aytakow (Oguzhan street)', 15],
                ['14-nji tapgyr (Sowhozny köç)', '14-th stage (Sowhozny street)', 15],
                ['15-nji tapgyr', '15-th stage', 15],
                ['Moskowskiý köç. (10 ýyl Abadançylyk şaýoly)', 'Moskowsky street. (10 years of Abadanchylyk shayoly)', 15],
                ['Nebitgaz (Andalib-Ankara köç.)', 'Nebitgaz (Andalib-Ankara street)', 15],
                ['Olimpiýa şäherçesi', 'Olympic town', 15],
                ['Sowetskiý köç. (Garaşsyzlyk şaýoly)', 'Sovetsky street (Garashsyzlyk shayoly)', 15],
                ['Garadamak', null, 15],
                ['Garadamak Şor', 'Garadamak Shor', 15],
                ['Gökje', 'Gokje', 15],
                ['G.Kuliýew köç. (Obýezdnoý)', 'G.Kuliyew street (Obyezdnoy)', 15],
                ['Gurtly', 'Gurtly', 15],
                ['Dosaaf', 'Dosaaf', 15],
                ['Kim raýon', 'Kim rayon', 15],
                ['Köpetdag şaýoly', 'Kopetdag shayoly', 15],
                ['Köşi', 'Koshi', 15],
                ['Parahat 1', 'Parahat 1', 15],
                ['Parahat 2', 'Parahat 2', 15],
                ['Parahat 3', 'Parahat 3', 15],
                ['Parahat 4', 'Parahat 4', 15],
                ['Parahat 5', 'Parahat 5', 15],
                ['Parahat 6', 'Parahat 6', 15],
                ['Parahat 7', 'Parahat 7', 15],
                ['Parahat 8', 'Parahat 8', 15],
                ['Gagarin köç, köne Howa menzili', 'Gagarin street, Old airport', 15],
                ['Gypjak', 'Gypjak', 15],
                ['Ruhabat (90-njy razýezd)', 'Ruhabat (90-th resolution)', 15],
                ['Täze zaman', 'Taze zaman', 15],
                ['Çoganly', 'Choganly', 15],
                ['Hitrowka', 'Hitrowka', 15],
                ['Herrikgala', 'Herrikgala', 15],
                ['Şor daça', 'Shor dacha', 15],
                ['Ýalkym', 'Yalkym', 15],
                ['Ýanbaş', 'Yanbash', 15],
            ]],
            ['Ahal', 'Akhal', [
                ['Ak bugdaý etraby', 'Ak bugday district', 30],
                ['Ýaşlyk', 'Yashlyk', 30],
                ['Bäherden', 'Baherden', 30],
                ['Babadaýhan', 'Babadayhan', 30],
                ['Gökdepe', 'Gokdepe', 30],
                ['Kaka', 'Kaka', 30],
                ['Änew', 'Anew', 30],
                ['Tejen', 'Tejen', 30],
                ['Sarahs', 'Sarahs', 30],
            ]],
            ['Balkan', 'Balkan', [
                ['Magtymguly', 'Magtymguly', 40],
                ['Bereket', 'Bereket', 40],
                ['Etrek', 'Etrek', 40],
                ['Esenguly', 'Esenguly', 40],
                ['Gumdag', 'Gumdag', 40],
                ['Balkanabat', 'Balkanabat', 40],
                ['Garabogaz', 'Garabogaz', 40],
                ['Hazar', 'Hazar', 40],
                ['Serdar', 'Serdar', 40],
                ['Türkmenbaşy', 'Turkmenbashy', 40],
                ['Jebel', 'Jebel', 40],
            ]],
            ['Mary', 'Mary', [
                ['Ýolöten', 'Yoloten', 30],
                ['Murgap', 'Murgap', 30],
                ['Mary', 'Mary', 30],
                ['Sakarçäge', 'Sakarchage', 30],
                ['Serhetabat (Guşgy)', 'Serhetabat (Gushgy)', 30],
                ['Tagtabazar', 'Tagtabazar', 30],
                ['Türkmengala', 'Turkmengala', 30],
                ['Oguz han', 'Oguz han', 30],
                ['Şatlyk', 'Shatlyk', 30],
                ['Baýramaly', 'Bayramaly', 30],
                ['Wekilbazar', 'Wekilbazar', 30],
                ['Garagum etraby', 'Garagum district', 30],
            ]],
            ['Lebap', 'Lebap', [
                ['Darganata', 'Darganata', 50],
                ['Farap', 'Farap', 50],
                ['Gazojak', 'Gazojak', 50],
                ['Dänew', 'Danew', 50],
                ['Türkmenabat', 'Turkmenabat', 50],
                ['Garabekewül', 'Garabekewul', 50],
                ['Dostluk', 'Dostluk', 50],
                ['Hojombaz', 'Hojombaz', 50],
                ['Köýtendag', 'Koytendag', 50],
                ['Magdanly', 'Magdanly', 50],
                ['Kerki', 'Kerki', 50],
                ['Sakar', 'Sakar', 50],
                ['Saýat', 'Sayat', 50],
                ['Seýdi', 'Seydi', 50],
                ['Çärjew', 'Charjew', 50],
                ['Halaç', 'Halach', 50],
            ]],
            ['Daşoguz', 'Dashoguz', [
                ['Akdepe', 'Akdepe', 50],
                ['Gurbansoltan Eje', 'Gurbansoltan Eje', 50],
                ['Boldumsaz', 'Boldumsaz', 50],
                ['Daşoguz', 'Dashoguz', 50],
                ['Gubadag', 'Gubadag', 50],
                ['Görogly (Tagta)', 'Gorogly (Tagta)', 50],
                ['Türkmenbaşy etraby ', 'Turkmenbashy district', 50],
                ['Ruhubelent etraby', 'Ruhubelent district', 50],
                ['Köneürgenç', 'Koneurgench', 50],
                ['S.A. Nyýazow etraby', 'S.A. Nyyazow district', 50],
            ]],
        ];

        for ($i = 0; $i < count($objs); $i++) {
            $location = Location::create([
                'name_tm' => $objs[$i][0],
                'name_en' => $objs[$i][1],
                'sort_order' => $i + 1,
            ]);

            for ($j = 0; $j < count($objs[$i][2]); $j++) {
                Location::create([
                    'parent_id' => $location->id,
                    'name_tm' => $objs[$i][2][$j][0],
                    'name_en' => $objs[$i][2][$j][1],
                    'sort_order' => $j + 1,
                ]);
            }
        }
    }
}
