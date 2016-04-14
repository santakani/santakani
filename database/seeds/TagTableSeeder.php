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
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('tag_translation')->insert([
            'tag_id' => 1,
            'locale' => 'en',
            'name' => 'Wood',
            'alias' => '',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('tag_translation')->insert([
            'tag_id' => 1,
            'locale' => 'zh',
            'name' => '木',
            'alias' => '',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        // 2
        DB::table('tag')->insert([
            'url_name' => 'knitwear',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('tag_translation')->insert([
            'tag_id' => 2,
            'locale' => 'en',
            'name' => 'Knitwear',
            'alias' => '',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('tag_translation')->insert([
            'tag_id' => 2,
            'locale' => 'zh',
            'name' => '针织品',
            'alias' => '',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        // 3
        DB::table('tag')->insert([
            'url_name' => 'bamboo',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('tag_translation')->insert([
            'tag_id' => 3,
            'locale' => 'en',
            'name' => 'Bamboo',
            'alias' => '',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('tag_translation')->insert([
            'tag_id' => 3,
            'locale' => 'zh',
            'name' => '竹',
            'alias' => '',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        // 4
        DB::table('tag')->insert([
            'url_name' => 'earring',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('tag_translation')->insert([
            'tag_id' => 4,
            'locale' => 'en',
            'name' => 'Earring',
            'alias' => 'Eardrop',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('tag_translation')->insert([
            'tag_id' => 4,
            'locale' => 'zh',
            'name' => '耳环',
            'alias' => '耳坠,耳钉',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        // 5 Fashion
        DB::table('tag')->insert([
            'url_name' => 'fashion',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('tag_translation')->insert([
            'tag_id' => 5,
            'locale' => 'en',
            'name' => 'Fashion',
            'alias' => '',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('tag_translation')->insert([
            'tag_id' => 5,
            'locale' => 'zh',
            'name' => '时尚',
            'alias' => '',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        // 6 Clothing
        DB::table('tag')->insert([
            'url_name' => 'clothing',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('tag_translation')->insert([
            'tag_id' => 6,
            'locale' => 'en',
            'name' => 'Clothing',
            'alias' => '',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('tag_translation')->insert([
            'tag_id' => 6,
            'locale' => 'zh',
            'name' => '服装',
            'alias' => '服饰，衣服，时装',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        // 7 Bag
        DB::table('tag')->insert([
            'url_name' => 'bag',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('tag_translation')->insert([
            'tag_id' => 7,
            'locale' => 'en',
            'name' => 'Bag',
            'alias' => '',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('tag_translation')->insert([
            'tag_id' => 7,
            'locale' => 'zh',
            'name' => '包',
            'alias' => '皮包，钱包，手提包',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        // 8 Woman
        DB::table('tag')->insert([
            'url_name' => 'woman',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('tag_translation')->insert([
            'tag_id' => 8,
            'locale' => 'en',
            'name' => 'Woman',
            'alias' => 'Female',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('tag_translation')->insert([
            'tag_id' => 8,
            'locale' => 'zh',
            'name' => '女性',
            'alias' => '女人，女式，女装',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
    }
}
