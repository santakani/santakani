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
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('city_translation')->insert([
            'city_id' => 1,
            'locale' => 'en',
            'name' => 'Helsinki',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('city_translation')->insert([
            'city_id' => 1,
            'locale' => 'zh',
            'name' => '赫尔辛基',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
    }
}
