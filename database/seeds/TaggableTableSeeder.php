<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

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
