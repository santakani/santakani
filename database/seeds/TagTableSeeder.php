<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class TagTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 1
        DB::table('tag')->insert([
            'url_name' => 'wood',
            'image_id' => 7,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('tag_translation')->insert([
            'tag_id' => 1,
            'language' => 'en',
            'name' => 'Wood',
            'content' => file_get_contents('http://loripsum.net/api'),
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('tag_translation')->insert([
            'tag_id' => 1,
            'language' => 'zh',
            'name' => '木',
            'content' => file_get_contents('http://loripsum.net/api'),
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        // 2
        DB::table('tag')->insert([
            'url_name' => 'knitwear',
            'image_id' => 8,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('tag_translation')->insert([
            'tag_id' => 2,
            'language' => 'en',
            'name' => 'Knitwear',
            'content' => file_get_contents('http://loripsum.net/api'),
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('tag_translation')->insert([
            'tag_id' => 2,
            'language' => 'zh',
            'name' => '针织品',
            'content' => file_get_contents('http://loripsum.net/api'),
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        // 3
        DB::table('tag')->insert([
            'url_name' => 'bamboo',
            'image_id' => 9,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('tag_translation')->insert([
            'tag_id' => 3,
            'language' => 'en',
            'name' => 'Bamboo',
            'content' => file_get_contents('http://loripsum.net/api'),
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('tag_translation')->insert([
            'tag_id' => 3,
            'language' => 'zh',
            'name' => '竹',
            'content' => file_get_contents('http://loripsum.net/api'),
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        // 4
        DB::table('tag')->insert([
            'url_name' => 'earring',
            'image_id' => 10,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('tag_translation')->insert([
            'tag_id' => 4,
            'language' => 'en',
            'name' => 'Earring',
            'content' => file_get_contents('http://loripsum.net/api'),
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('tag_translation')->insert([
            'tag_id' => 4,
            'language' => 'zh',
            'name' => '耳环',
            'content' => file_get_contents('http://loripsum.net/api'),
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
    }
}
