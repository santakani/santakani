<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

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
            $x = 60.1686973 + rand(0, 1000) / 1000 - 0.5;
            $y = 24.9512867 + rand(0, 1000) / 1000 - 0.5;
            $point = "PointFromText('POINT($x $y)')";

            DB::table('place')->insert([
                'country_id' => $place[0],
                'city_id' => $place[1],
                'location' => DB::raw($point),
                'image_id' => $place[2],
                'user_id' => $place[3],
                'type' => 'store',
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
                'address' => 'Servinkuja 1 B 19',
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
            ]);
        }

    }
}
