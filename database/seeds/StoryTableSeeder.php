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

use App\City;
use App\Image;
use App\User;

/**
 * StoryTableSeeder
 *
 * Fill test data into "story" and "story_translation" table.
 *
 * @author Guo Yunhe <guoyunhebrave@gmail.com>
 * @see https://github.com/santakani/santakani.com/wiki/Story
 * @see https://github.com/santakani/santakani.com/wiki/Test-Data
 */
class StoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 100; $i++) {
            $id = DB::table('story')->insertGetId([
                'image_id' => rand(1,30),
                'user_id' => rand(1,3),
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ]);

            DB::table('story_translation')->insert([
                'story_id' => $id,
                'locale' => 'en',
                'title' => 'Test Story ' . $id,
                'content' => file_get_contents('http://loripsum.net/api'),
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ]);
        }

    }
}
