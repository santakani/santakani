<?php

/*
 * This file is part of Santakani
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
            'bags',
            'clothing',
            'decoration',
            'eardrop',
            'earring',
            'furniture',
            'handmade',
            'illustration',
            'interior',
            'jewelry',
            'keychain',
            'kitchenware',
            'magnet',
            'postcard',
            'tableware',
            'timeless',
            'wood fire',
        ];

        foreach ($tags as $tag) {
            $id = DB::table('tag')->insertGetId([
                'level' => rand(0,255),
                'image_id' => rand(1,30),
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ]);

            DB::table('tag_translation')->insert([
                'tag_id' => $id,
                'locale' => 'en',
                'name' => $tag,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ]);
        }
    }
}
