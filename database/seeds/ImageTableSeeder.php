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
 * ImageTableSeeder
 *
 * Fill test data into "image" table. You also need to manully store files in
 * "public/storage/image".
 *
 * @author Guo Yunhe <guoyunhebrave@gmail.com>
 * @see https://github.com/santakani/santakani.com/wiki/Image
 * @see https://github.com/santakani/santakani.com/wiki/Test-Data
 */
class ImageTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $images = [
            1  => [4608, 3072, 1, 'designer', 1],
            2  => [4608, 3072, 1, 'designer', 1],
            3  => [4608, 3072, 1, 'designer', 1],
            4  => [4608, 3072, 1, 'designer', 1],
            5  => [4608, 3072, 1, 'designer', 1],
            6  => [4608, 3072, 1, 'designer', 1],
            7  => [4608, 3072, 1, 'designer', 1],
            8  => [4608, 3072, 1, 'designer', 1],
            9  => [3072, 4608, 1, 'designer', 1],
            10 => [4608, 3072, 1, 'designer', 1],
            11 => [4608, 3072, 1, 'designer', 1],
            12 => [2871, 3758, 2, 'designer', 2],
            13 => [4308, 3072, 2, 'designer', 2],
            14 => [3744, 2562, 2, 'designer', 2],
            15 => [4134, 2958, 2, 'designer', 2],
            16 => [4608, 3072, 2, 'designer', 2],
            17 => [4608, 2454, 2, 'designer', 2],
            18 => [4200, 3072, 2, 'designer', 2],
            19 => [2003, 3850, 2, 'designer', 2],
            20 => [4608, 3072, 2, 'designer', 2],
            21 => [4608, 3072, 2, 'designer', 2],
            22 => [2824, 4608, 2, 'designer', 2],
            23 => [3072, 4608, 2, 'designer', 2],
            24 => [1600, 900, 1, 'country', 1],
            25 => [1600, 1066, 1, 'country', 2],
            26 => [1600, 600, 1, 'country', 3],
            27 => [1024, 768, 1, 'country', 4],
            28 => [1600, 946, 1, 'city', 1],
            29 => [1600, 1066, 1, 'city', 2],
            30 => [1920, 805, 1, 'city', 3],
            31 => [4000, 3000, 1, 'city', 4],
            32 => [2000, 1505, 1, 'city', 5],
            33 => [2560, 1920, 1, 'city', 6],
            34 => [1960, 685, 1, 'city', 7],
            35 => [1500, 1000, 1, 'city', 8],
        ];

        $time_stamp = Carbon::now()->format('Y-m-d H:i:s');

        foreach ($images as $image) {
            DB::table('image')->insert([
                'mime_type' => 'image/jpeg',
                'width' => $image[0],
                'height' => $image[1],
                'user_id' => $image[2],
                'parent_type' => $image[3],
                'parent_id' => $image[4],
                'created_at' => $time_stamp,
                'updated_at' => $time_stamp
            ]);
        }
    }
}
