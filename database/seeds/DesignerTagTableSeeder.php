<?php

use Illuminate\Database\Seeder;

class DesignerTagTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('designer_tag')->insert([
            'designer_id' => 1,
            'tag_id' => 5,
        ]);

        DB::table('designer_tag')->insert([
            'designer_id' => 1,
            'tag_id' => 6,
        ]);

        DB::table('designer_tag')->insert([
            'designer_id' => 1,
            'tag_id' => 7,
        ]);

        DB::table('designer_tag')->insert([
            'designer_id' => 1,
            'tag_id' => 8,
        ]);
    }
}
