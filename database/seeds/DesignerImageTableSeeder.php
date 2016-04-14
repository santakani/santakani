<?php

use Illuminate\Database\Seeder;

class DesignerImageTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('designer_image')->insert([
            'designer_id' => 1,
            'image_id' => 14,
            'order' => 0,
        ]);

        DB::table('designer_image')->insert([
            'designer_id' => 1,
            'image_id' => 15,
            'order' => 1,
        ]);

        DB::table('designer_image')->insert([
            'designer_id' => 1,
            'image_id' => 16,
            'order' => 2,
        ]);

        DB::table('designer_image')->insert([
            'designer_id' => 1,
            'image_id' => 17,
            'order' => 3,
        ]);

        DB::table('designer_image')->insert([
            'designer_id' => 1,
            'image_id' => 18,
            'order' => 4,
        ]);

        DB::table('designer_image')->insert([
            'designer_id' => 1,
            'image_id' => 19,
            'order' => 5,
        ]);

        DB::table('designer_image')->insert([
            'designer_id' => 1,
            'image_id' => 20,
            'order' => 6,
        ]);
    }
}
