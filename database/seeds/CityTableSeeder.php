<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class CityTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cities = [
            1 => ['helsinki', 1, 28, 'Helsinki', '赫尔辛基'],
            2 => ['espoo', 1, 29, 'Espoo', '埃斯波'],
            3 => ['vantaa', 1, 30, 'Vantaa', '万塔'],
            4 => ['turku', 1, 31, 'Turku', '图尔库'],
            5 => ['tampere', 1, 32, 'Tampere', '坦佩雷'],
            6 => ['oulu', 1, 33, 'Oulu', '奥卢'],
            7 => ['rovaniemi', 1, 34, 'Rovaniemi', '罗瓦涅米'],
            8 => ['lahti', 1, 35, 'Lahti', '拉赫蒂'],
        ];

        foreach ($cities as $id => $city) {
            DB::table('city')->insert([
                'slug' => $city[0],
                'country_id' => $city[1],
                'image_id' => $city[2],
            ]);

            DB::table('city_translation')->insert([
                'city_id' => $id,
                'locale' => 'en',
                'name' => $city[3],
            ]);

            DB::table('city_translation')->insert([
                'city_id' => $id,
                'locale' => 'zh',
                'name' => $city[4],
            ]);
        }
    }
}
