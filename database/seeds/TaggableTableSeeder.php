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
        $taggables = [
            [1, 'designer', 1],
            [2, 'designer', 1],
            [3, 'designer', 1],
            [4, 'designer', 1],
            [1, 'designer', 2],
            [2, 'designer', 2],
            [3, 'designer', 2],
            [4, 'designer', 2],
            [1, 'place', 1],
            [2, 'place', 1],
            [3, 'place', 1],
        ];

        foreach ($taggables as $taggable) {
            DB::table('taggable')->insert([
                'tag_id' => $taggable[0],
                'taggable_type' => $taggable[1],
                'taggable_id' => $taggable[2],
            ]);
        }
    }
}
