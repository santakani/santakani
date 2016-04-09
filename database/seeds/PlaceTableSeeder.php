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
        // 1
        DB::table('place')->insert([
            'country_id' => 1,
            'city_id' => 1,
            'location' => DB::raw("PointFromText('POINT(60.1686973 24.9512867)')"),
            'image_id' => 1,
            'type' => 'shop',
            'address' => 'Katrinegatan 4',
            'email' => 'info@example.com',
            'phone' => '+358123456789',
            'website' => 'http://example.com/',
            'user_id' => 1,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('place_translation')->insert([
            'place_id' => 1,
            'language' => 'en',
            'name' => 'MadeBy Helsinki',
            'content' => file_get_contents('http://loripsum.net/api'),
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        // 2
        DB::table('place')->insert([
            'country_id' => 1,
            'city_id' => 1,
            'location' => DB::raw("PointFromText('POINT(60.2029699 24.9482206)')"),
            'image_id' => 2,
            'type' => 'shop',
            'address' => 'Aleksis Kivis gata 74',
            'email' => 'info@example.com',
            'phone' => '+358123456789',
            'website' => 'http://example.com/',
            'user_id' => 1,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('place_translation')->insert([
            'place_id' => 2,
            'language' => 'en',
            'name' => 'Uniqeco Design',
            'content' => file_get_contents('http://loripsum.net/api'),
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        // 3
        DB::table('place')->insert([
            'country_id' => 1,
            'city_id' => 1,
            'location' => DB::raw("PointFromText('POINT(60.1880678 24.9211522)')"),
            'image_id' => 3,
            'type' => 'studio',
            'address' => 'Aleksis Kivis gata 74',
            'email' => 'info@example.com',
            'phone' => '+358123456789',
            'website' => 'http://example.com/',
            'user_id' => 1,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('place_translation')->insert([
            'place_id' => 3,
            'language' => 'en',
            'name' => 'Tiisin Design',
            'content' => file_get_contents('http://loripsum.net/api'),
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        // 4
        DB::table('place')->insert([
            'country_id' => 1,
            'city_id' => 1,
            'location' => DB::raw("PointFromText('POINT(60.2032442 24.9510651)')"),
            'image_id' => 4,
            'type' => 'studio',
            'address' => 'Aleksis Kivis gata 74',
            'email' => 'info@example.com',
            'phone' => '+358123456789',
            'website' => 'http://example.com/',
            'user_id' => 1,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('place_translation')->insert([
            'place_id' => 4,
            'language' => 'en',
            'name' => 'Sebastian Jansson',
            'content' => file_get_contents('http://loripsum.net/api'),
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
    }
}
