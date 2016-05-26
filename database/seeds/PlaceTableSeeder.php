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
 * PlaceTableSeeder
 *
 * Fill test data into "place" and "place_translation" table.
 *
 * @author Guo Yunhe <guoyunhebrave@gmail.com>
 * @see https://github.com/santakani/santakani.com/wiki/Place
 * @see https://github.com/santakani/santakani.com/wiki/Test-Data
 */
class PlaceTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $places = [
            1 => [1, 1, 1, 1, 'Costo'],
            2 => [1, 1, 23, 1, 'folklore'],
            3 => [1, 1, 1, 1, 'Costo'],
            4 => [1, 1, 23, 1, 'folklore'],
            5 => [1, 1, 1, 1, 'Costo'],
            6 => [1, 1, 23, 1, 'folklore'],
            7 => [1, 1, 1, 1, 'Costo'],
            8 => [1, 1, 23, 1, 'folklore'],
            9 => [1, 1, 1, 1, 'Costo'],
            10 => [1, 1, 23, 1, 'folklore'],
        ];

        $timestamp = Carbon::now()->format('Y-m-d H:i:s');

        foreach ($places as $id => $place) {
            DB::table('place')->insert([
                'country_id' => $place[0],
                'city_id' => $place[1],
                'image_id' => $place[2],
                'user_id' => $place[3],
                'type' => 'store',
                'address' => 'Servinkuja 1 B 19',
                'latitude' => 60.1686973 + rand(0, 1000) / 20000 - 0.025,
                'longitude' => 24.9512867 + rand(0, 1000) / 20000 - 0.025,
                'phone' => '+3581234567',
                'email' => 'contact@example.com',
                'website' => 'http://www.example.com/',
                'facebook' => 'https://www.facebook.com/',
                'google_plus' => 'https://plus.google.com/',
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
            ]);

            DB::table('place_translation')->insert([
                'place_id' => $id,
                'locale' => 'en',
                'name' => $place[4],
                'content' => file_get_contents('http://loripsum.net/api'),
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
            ]);
        }

    }
}
