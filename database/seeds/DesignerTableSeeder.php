<?php

/*
 * This file is part of Santakani
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

/**
 * DesignerTableSeeder
 *
 * Fill test data into "designer" and "designer_translation" table.
 *
 * @author Guo Yunhe <guoyunhebrave@gmail.com>
 * @see https://github.com/santakani/santakani.com/wiki/Designer
 * @see https://github.com/santakani/santakani.com/wiki/Test-Data
 */
class DesignerTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cities = [];

        $cities[] = City::where('geoname_id', 658225)->first();
        $cities[] = City::where('geoname_id', 649360)->first();
        $cities[] = City::where('geoname_id', 660158)->first();
        $cities[] = City::where('geoname_id', 632453)->first();
        $cities[] = City::where('geoname_id', 634963)->first();

        $images = Image::all();

        $users = User::all();

        for ($i = 0; $i < 100; $i++) {
            $city = $cities[rand(0, count($cities)-1)];
            $image = $images[rand(0, count($images)-1)];
            $logo_image = $images[rand(0, count($images)-1)];
            $user = $users[rand(0, count($users)-1)];

            $id = DB::table('designer')->insertGetId([
                'city_id' => $city->id,
                'image_id' => $image->id,
                'logo_id' => $logo_image->id,
                'user_id' => $user->id,
                'email' => 'contact@example.com',
                'website' => 'http://www.example.com/',
                'facebook' => 'https://www.facebook.com/',
                'twitter' => 'https://twitter.com/',
                'google_plus' => 'https://plus.google.com/',
                'instagram' => 'https://www.instagram.com/',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ]);

            DB::table('designer_translation')->insert([
                'designer_id' => $id,
                'locale' => 'en',
                'name' => 'Test Designer ' . $id,
                'tagline' => 'Good typeface make any text easier to read',
                'content' => file_get_contents('http://loripsum.net/api'),
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ]);
        }

    }
}
