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
            1  => [4608, 3072, 1, 'designer', 1, 1],
            2  => [4608, 3072, 1, 'designer', 1, 2],
            3  => [4608, 3072, 1, 'designer', 1, 3],
            4  => [4608, 3072, 1, 'designer', 1, 4],
            5  => [4608, 3072, 1, 'designer', 1, 5],
            6  => [4608, 3072, 1, 'designer', 1, 6],
            7  => [4608, 3072, 1, 'designer', 1, 7],
            8  => [4608, 3072, 1, 'designer', 1, 8],
            9  => [3072, 4608, 1, 'designer', 1, 9],
            10 => [4608, 3072, 1, 'designer', 2, null],
            11 => [4608, 3072, 1, 'designer', 2, 1],
            12 => [2871, 3758, 2, 'designer', 2, 3],
            13 => [4308, 3072, 2, 'designer', 2, 2],
            14 => [3744, 2562, 2, 'designer', 2, 7],
            15 => [4134, 2958, 2, 'designer', 2, 6],
            16 => [4608, 3072, 2, 'designer', 2, 5],
            17 => [4608, 2454, 2, 'designer', 2, 8],
            18 => [4200, 3072, 2, 'designer', 2, null],
            19 => [2003, 3850, 2, 'designer', 2, 4],
            20 => [4608, 3072, 2, 'place', 1, 1],
            21 => [4608, 3072, 2, 'place', 1, 6],
            22 => [2824, 4608, 2, 'place', 2, 5],
            23 => [3072, 4608, 2, 'place', 2, 9],
            24 => [1600, 900, 1, 'country', 1, null],
            25 => [1600, 1066, 1, 'country', 2, null],
            26 => [1600, 600, 1, 'country', 3, null],
            27 => [1024, 768, 1, 'country', 4, null],
            28 => [1600, 946, 1, 'city', 1, null],
            29 => [1600, 1066, 1, 'city', 2, null],
            30 => [1920, 805, 1, 'city', 3, null],
            31 => [4000, 3000, 1, 'city', 4, null],
            32 => [2000, 1505, 1, 'city', 5, null],
            33 => [2560, 1920, 1, 'city', 6, null],
            34 => [1960, 685, 1, 'city', 7, null],
            35 => [1500, 1000, 1, 'city', 8, null],
        ];

        foreach ($images as $image) {
            DB::table('image')->insert([
                'mime_type' => 'image/jpeg',
                'width' => $image[0],
                'height' => $image[1],
                'user_id' => $image[2],
                'parent_type' => $image[3],
                'parent_id' => $image[4],
                'weight' => $image[5],
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ]);
        }
    }
}
