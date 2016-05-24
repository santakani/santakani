<?php

/*
 * This file is part of santakani.com
 *
 * (c) Guo Yunhe <guoyunhebrave@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Illuminate\Database\Seeder;
use Carbon\Carbon;

/**
 * TagTableSeeder
 *
 * Fill test data into "tag" and "tag_translation" table.
 *
 * @author Guo Yunhe <guoyunhebrave@gmail.com>
 * @see https://github.com/santakani/santakani.com/wiki/Tag
 * @see https://github.com/santakani/santakani.com/wiki/Test-Data
 */
class TagTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tags = [
            1 => ['wood', 1, 'Wood', 'Wooden,Tree', '木', '木头,木材'],
            2 => ['hat', 2, 'Hat', 'Cap', '帽子', '帽'],
            3 => ['eco', 3, 'Ecology', 'Ecological,Envirnment-friendly', '环保', ''],
            4 => ['handmade', 4, 'Handmade', 'Handcrafted', '手工', '人工'],
            5 => ['timeless', 5, 'Timeless', 'Forever', '历久弥新', '永恒'],
            6 => ['jewelry', 6, 'Jewelry', 'Jewellery,Ornament', '首饰', ''],
            7 => ['accessory', 7, 'Accessory', '', '饰品', ''],
            8 => ['earring', 8, 'Earring', '', '耳环', ''],
            9 => ['eardrop', 9, 'Eardrop', '', '耳坠', ''],
        ];
        $timestamp = Carbon::now()->format('Y-m-d H:i:s');

        foreach ($tags as $id => $tag) {
            DB::table('tag')->insert([
                'slug' => $tag[0],
                'image_id' => $tag[1],
                'created_at' => $timestamp,
            ]);

            DB::table('tag_translation')->insert([
                'tag_id' => $id,
                'locale' => 'en',
                'name' => $tag[2],
                'alias' => $tag[3],
                'created_at' => $timestamp,
            ]);

            DB::table('tag_translation')->insert([
                'tag_id' => $id,
                'locale' => 'zh',
                'name' => $tag[4],
                'alias' => $tag[5],
                'created_at' => $timestamp,
            ]);
        }
    }
}
