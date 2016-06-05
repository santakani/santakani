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

use App\Designer;
use App\Place;
use App\Tag;

/**
 * TaggableTableSeeder
 *
 * Fill test data into "taggable" table.
 *
 * @author Guo Yunhe <guoyunhebrave@gmail.com>
 * @see https://github.com/santakani/santakani.com/wiki/Tag
 * @see https://github.com/santakani/santakani.com/wiki/Test-Data
 */
class TaggableTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $designer_ids = Designer::all()->pluck('id');

        $this->batchRandomTags($designer_ids, 'designer');

        $place_ids = Place::all()->pluck('id');

        $this->batchRandomTags($place_ids, 'place');
    }

    public function batchRandomTags($ids, $type) {
        foreach ($ids as $id) {
            $tag_ids = Tag::orderByRaw('RAND()')->take(rand(3, 6))->get()->pluck('id');

            foreach ($tag_ids as $tag_id) {
                DB::table('taggable')->insert([
                    'tag_id' => $tag_id,
                    'taggable_type' => $type,
                    'taggable_id' => $id,
                ]);
            }
        }
    }
}
