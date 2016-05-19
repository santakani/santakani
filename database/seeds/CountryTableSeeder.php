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
        $countries = [
            1 => ['finland', 'FI', 24, 'Finland', '芬兰'],
            2 => ['china', 'CN', 25, 'China', '中国'],
            3 => ['germany', 'DE', 26, 'Germany', '德国'],
            4 => ['japan', 'JP', 27, 'Japan', '日本'],
        ];

        foreach ($countries as $id => $country) {
            DB::table('country')->insert([
                'slug' => $country[0],
                'code' => $country[1],
                'image_id' => $country[2],
            ]);

            DB::table('country_translation')->insert([
                'country_id' => $id,
                'locale' => 'en',
                'name' => $country[3],
                'content' => file_get_contents('http://loripsum.net/api'),
            ]);

            DB::table('country_translation')->insert([
                'country_id' => $id,
                'locale' => 'zh',
                'name' => $country[4],
                'content' => file_get_contents('http://loripsum.net/api'),
            ]);
        }
    }
}
