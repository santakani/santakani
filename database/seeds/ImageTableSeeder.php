<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ImageTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 1
        DB::table('image')->insert([
            'mime_type' => 'image/jpeg',
            'width' => 994,
            'height' => 1138,
            'user_id' => 1,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        // 2
        DB::table('image')->insert([
            'mime_type' => 'image/jpeg',
            'width' => 1200,
            'height' => 900,
            'user_id' => 1,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        // 3
        DB::table('image')->insert([
            'mime_type' => 'image/png',
            'width' => 1200,
            'height' => 1200,
            'user_id' => 1,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        // 4
        DB::table('image')->insert([
            'mime_type' => 'image/jpeg',
            'width' => 1200,
            'height' => 1200,
            'user_id' => 1,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        // 5
        DB::table('image')->insert([
            'mime_type' => 'video/youtube',
            'width' => 1280,
            'height' => 720,
            'external_url' => 'https://www.youtube.com/watch?v=KLELsFKC6o4',
            'user_id' => 1,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        // 6
        DB::table('image')->insert([
            'mime_type' => 'video/vimeo',
            'width' => 1280,
            'height' => 720,
            'external_url' => 'https://vimeo.com/16922821',
            'user_id' => 1,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        // 7
        DB::table('image')->insert([
            'mime_type' => 'image/jpeg',
            'width' => 1200,
            'height' => 1039,
            'user_id' => 1,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        // 8
        DB::table('image')->insert([
            'mime_type' => 'image/jpeg',
            'width' => 580,
            'height' => 386,
            'user_id' => 1,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        // 9
        DB::table('image')->insert([
            'mime_type' => 'image/jpeg',
            'width' => 480,
            'height' => 311,
            'user_id' => 1,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        // 10
        DB::table('image')->insert([
            'mime_type' => 'image/jpeg',
            'width' => 570,
            'height' => 570,
            'user_id' => 1,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        // 11
        DB::table('image')->insert([
            'mime_type' => 'image/jpeg',
            'width' => 1200,
            'height' => 900,
            'user_id' => 1,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        // 12
        DB::table('image')->insert([
            'mime_type' => 'image/jpeg',
            'width' => 1200,
            'height' => 750,
            'user_id' => 1,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        // 13, YAT designer photo
        DB::table('image')->insert([
            'mime_type' => 'image/jpeg',
            'width' => 460,
            'height' => 280,
            'user_id' => 1,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        // 14, YAT design photo
        DB::table('image')->insert([
            'mime_type' => 'image/jpeg',
            'width' => 287,
            'height' => 395,
            'user_id' => 1,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        // 15, YAT design photo
        DB::table('image')->insert([
            'mime_type' => 'image/jpeg',
            'width' => 263,
            'height' => 395,
            'user_id' => 1,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        // 16, YAT design photo
        DB::table('image')->insert([
            'mime_type' => 'image/jpeg',
            'width' => 800,
            'height' => 1200,
            'user_id' => 1,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        // 17, YAT design photo
        DB::table('image')->insert([
            'mime_type' => 'image/jpeg',
            'width' => 800,
            'height' => 1200,
            'user_id' => 1,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        // 18, YAT design photo
        DB::table('image')->insert([
            'mime_type' => 'image/jpeg',
            'width' => 800,
            'height' => 1200,
            'user_id' => 1,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        // 19, YAT design photo
        DB::table('image')->insert([
            'mime_type' => 'image/jpeg',
            'width' => 800,
            'height' => 1200,
            'user_id' => 1,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        // 20, YAT design photo
        DB::table('image')->insert([
            'mime_type' => 'image/jpeg',
            'width' => 1200,
            'height' => 608,
            'user_id' => 1,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
    }
}
