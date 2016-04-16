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
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('country_translation')->insert([
            'country_id' => 1,
            'locale' => 'en',
            'name' => 'Finland',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('country_translation')->insert([
            'country_id' => 1,
            'locale' => 'zh',
            'name' => '芬兰',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
    }
}
