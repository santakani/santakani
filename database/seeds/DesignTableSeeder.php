<?php

use Carbon\Carbon;

use Illuminate\Database\Seeder;

class DesignTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $content = file_get_contents('http://loripsum.net/api');

        for ($i = 0; $i < 1000; $i++) {
            $price = rand(1,99999) / 100;
            $id = DB::table('design')->insertGetId([
                'image_id' => rand(1,30),
                'designer_id' => rand(1,100),
                'user_id' => rand(1,3),
                'webshop' => 'http://example.com/',
                'price' => $price,
                'currency' => 'EUR',
                'eur_price' => $price,
                'taobao' => 'http://taobao.com',
                'taobao_price' => $price * 7,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ]);

            DB::table('design_translation')->insert([
                'design_id' => $id,
                'locale' => 'en',
                'name' => 'Test Design ' . $id,
                'content' => $content,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ]);
        }
    }
}
