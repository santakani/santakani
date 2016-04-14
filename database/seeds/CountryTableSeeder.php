<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class CountryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 1
        DB::table('country')->insert([
            'url_name' => 'finland',
            'code' => 'fi',
            'image_id' => 11,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('country_translation')->insert([
            'country_id' => 1,
            'language' => 'en',
            'name' => 'Finland',
            'content' => file_get_contents('http://loripsum.net/api'),
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('country_translation')->insert([
            'country_id' => 1,
            'language' => 'zh',
            'name' => '芬兰',
            'content' => file_get_contents('http://loripsum.net/api'),
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
    }
}
