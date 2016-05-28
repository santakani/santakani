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

        $cities[] = City::where('slug', 'helsinki')->first();
        $cities[] = City::where('slug', 'lahti')->first();
        $cities[] = City::where('slug', 'espoo')->first();
        $cities[] = City::where('slug', 'vantaa')->first();
        $cities[] = City::where('slug', 'tampere')->first();

        $images = Image::all();

        $users = User::all();

        for ($i = 0; $i < 100; $i++) {
            $city = $cities[rand(0, count($cities)-1)];
            $image = $images[$i%count($images)];
            $user = $users[rand(0, count($users)-1)];

            $id = DB::table('designer')->insertGetId([
                'city_id' => $city->id,
                'image_id' => $image->id,
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
