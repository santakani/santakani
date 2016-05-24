<?php

/*
 * This file is part of santakani.com
 *
 * (c) Guo Yunhe <guoyunhebrave@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Illuminate\Database\Seeder;
use Carbon\Carbon;

/**
 * CityTableSeeder
 *
 * Fill test data into "city" and "city_translation" table.
 *
 * @author Guo Yunhe <guoyunhebrave@gmail.com>
 * @see https://github.com/santakani/santakani.com/wiki/City
 * @see https://github.com/santakani/santakani.com/wiki/Test-Data
 */
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
            // slug => [image_id, name_zh, name_fi, name_sv]
            'helsinki' => [28, '赫尔辛基', 'Helsinki', 'Helsingfors'],
            'espoo' => [29, '埃斯波', 'Espoo', 'Esbo'],
            'vantaa' => [30, '万塔', 'Vantaa', 'Vanda'],
            'turku' => [31, '图尔库', 'Turku', 'Åbo'],
            'tampere' => [32, '坦佩雷', 'Tampere', 'Tammerfors'],
            'oulu' => [33, '奥卢', 'Oulu', 'Uleåborg'],
            'rovaniemi' => [34, '罗瓦涅米', 'Rovaniemen', 'Rovaniemi'],
            'lahti' => [35, '拉赫蒂', 'Lahti', 'Lahtis'],
        ];

        $timestamp = Carbon::now()->format('Y-m-d H:i:s');

        foreach ($cities as $slug => $city) {
            DB::table('city')->where('slug', $slug)->update([
                'image_id' => $city[0],
            ]);

            $id = DB::table('city')->where('slug', $slug)->first()->id;

            DB::table('city_translation')->insert([
                'city_id' => $id,
                'locale' => 'zh',
                'name' => $city[1],
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
            ]);

            DB::table('city_translation')->insert([
                'city_id' => $id,
                'locale' => 'fi',
                'name' => $city[2],
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
            ]);

            DB::table('city_translation')->insert([
                'city_id' => $id,
                'locale' => 'sv',
                'name' => $city[3],
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
            ]);
        }
    }
}
