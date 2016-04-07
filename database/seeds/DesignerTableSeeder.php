<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class DesignerTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('designer')->insert([
            'image_id' => 1,
            'user_id' => 1,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('designer_translation')->insert([
            'designer_id' => 1,
            'language' => 'en',
            'name' => 'Guo Yunhe',
            'content' => file_get_contents('http://loripsum.net/api'),
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('designer_translation')->insert([
            'designer_id' => 1,
            'language' => 'zh',
            'name' => '郭云鹤',
            'content' => file_get_contents('http://loripsum.net/api'),
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('designer')->insert([
            'image_id' => 2,
            'user_id' => 2,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

         DB::table('designer_translation')->insert([
            'designer_id' => 2,
            'language' => 'en',
            'name' => 'Du Yuexin',
            'content' => file_get_contents('http://loripsum.net/api'),
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('designer_translation')->insert([
            'designer_id' => 2,
            'language' => 'zh',
            'name' => '杜玥辛',
            'content' => file_get_contents('http://loripsum.net/api'),
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('designer')->insert([
            'image_id' => 3,
            'user_id' => 3,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

         DB::table('designer_translation')->insert([
            'designer_id' => 3,
            'language' => 'en',
            'name' => 'Yun Xiaotong',
            'content' => file_get_contents('http://loripsum.net/api'),
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('designer_translation')->insert([
            'designer_id' => 3,
            'language' => 'zh',
            'name' => '云小童',
            'content' => file_get_contents('http://loripsum.net/api'),
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('designer')->insert([
            'image_id' => 4,
            'user_id' => 1,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

         DB::table('designer_translation')->insert([
            'designer_id' => 4,
            'language' => 'en',
            'name' => 'Yu Huiyang',
            'content' => file_get_contents('http://loripsum.net/api'),
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('designer_translation')->insert([
            'designer_id' => 4,
            'language' => 'zh',
            'name' => '余慧阳',
            'content' => file_get_contents('http://loripsum.net/api'),
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
    }
}
