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
        // 1
        DB::table('city')->insert([
            'url_name' => 'helsinki',
            'country_id' => 1,
            'image_id' => 12,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('city_translation')->insert([
            'city_id' => 1,
            'language' => 'en',
            'name' => 'Helsinki',
            'content' => file_get_contents('http://loripsum.net/api'),
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('city_translation')->insert([
            'city_id' => 1,
            'language' => 'zh',
            'name' => '赫尔辛基',
            'content' => file_get_contents('http://loripsum.net/api'),
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
    }
}
