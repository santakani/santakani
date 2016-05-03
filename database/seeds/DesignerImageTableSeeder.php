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
        ]);

        DB::table('designer_image')->insert([
            'designer_id' => 1,
            'image_id' => 15,
        ]);

        DB::table('designer_image')->insert([
            'designer_id' => 1,
            'image_id' => 16,
        ]);

        DB::table('designer_image')->insert([
            'designer_id' => 1,
            'image_id' => 17,
        ]);

        DB::table('designer_image')->insert([
            'designer_id' => 1,
            'image_id' => 18,
        ]);

        DB::table('designer_image')->insert([
            'designer_id' => 1,
            'image_id' => 19,
        ]);

        DB::table('designer_image')->insert([
            'designer_id' => 1,
            'image_id' => 20,
        ]);
    }
}
