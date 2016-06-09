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

use App\City;
use App\Image;
use App\User;
use App\Place;

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
        $cities = [];

        $cities[] = City::where('slug', 'helsinki')->first();
        $cities[] = City::where('slug', 'lahti')->first();
        $cities[] = City::where('slug', 'espoo')->first();
        $cities[] = City::where('slug', 'vantaa')->first();
        $cities[] = City::where('slug', 'tampere')->first();

        $images = Image::all();

        $users = User::all();

        $types = Place::types();

        for ($i = 0; $i < 100; $i++) {
            $city = $cities[rand(0, count($cities)-1)];
            $image = $images[$i%count($images)];
            $user = $users[rand(0, count($users)-1)];
            $type = $types[rand(0, count($types)-1)];

            $id = DB::table('place')->insertGetId([
                'city_id' => $city->id,
                'image_id' => $image->id,
                'user_id' => $user->id,
                'type' => $type,
                'address' => 'Servinkuja 1 B 19',
                'latitude' => $city->latitude + rand(0, 1000) / 20000 - 0.025,
                'longitude' => $city->longitude + rand(0, 1000) / 20000 - 0.025,
                'phone' => '+3581234567',
                'email' => 'contact@example.com',
                'website' => 'http://www.example.com/',
                'facebook' => 'https://www.facebook.com/',
                'google_plus' => 'https://plus.google.com/',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ]);

            DB::table('place_translation')->insert([
                'place_id' => $id,
                'locale' => 'en',
                'name' => 'Test ' . $type . ' ' . $id,
                'content' => file_get_contents('http://loripsum.net/api'),
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ]);
        }

    }
}
