<?php

/*
 * This file is part of Santakani
 *
 * (c) Guo Yunhe <guoyunhebrave@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Illuminate\Database\Seeder;
use Carbon\Carbon;

/**
 * DesignerTableSeeder
 *
 * Fill test data into "designer" and "designer_translation" table.
 *
 * @author Guo Yunhe <guoyunhebrave@gmail.com>
 * @see https://github.com/santakani/santakani.com/wiki/Designer
 * @see https://github.com/santakani/santakani.com/wiki/Test-Data
 */
class DesignerTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cities = App\City::where('geoname_id', 658225)
                  ->orWhere('geoname_id', 649360)
                  ->orWhere('geoname_id', 660158)
                  ->orWhere('geoname_id', 632453)
                  ->orWhere('geoname_id', 634963)
                  ->get();

        $users = App\User::all();

        $designers = factory(App\Designer::class, 50)->create()->each(function ($designer) use ($cities, $users) {
            $designer->translations()->save(factory(App\DesignerTranslation::class)->make());

            $designer->city()->associate($cities->get(intval(rand(0,5))));
            $designer->user()->associate($users->pop());

            // Download cover image
            $image = new App\Image();
            $temp = tempnam(sys_get_temp_dir(), 'santakani-image-download-');
            file_put_contents($temp, fopen("https://source.unsplash.com/category/people", 'r'));
            $size = getimagesize($temp);
            $image->mime_type = $size['mime'];
            $image->width = $size[0];
            $image->height = $size[1];
            $image->save();
            $image->saveFile($temp);

            $designer->image()->associate($image);
            $designer->save();
            $designer->images()->save($image);

            // Download logo image
            $logo = new App\Image();
            $temp = tempnam(sys_get_temp_dir(), 'santakani-image-download-');
            file_put_contents($temp, fopen('http://www.gravatar.com/avatar/'.md5($designer->email).'?s=300&d=identicon', 'r'));
            $size = getimagesize($temp);
            $logo->mime_type = $size['mime'];
            $logo->width = $size[0];
            $logo->height = $size[1];
            $logo->save();
            $logo->saveFile($temp);

            $designer->logo()->associate($logo);
            $designer->save();
            $designer->images()->save($logo);

            sleep(3); // Avoid downloading the same image because of HTTP cache

            $n = rand(0, 10);

            for ($i = 0; $i < $n; $i++) {
                $image = new App\Image();
                $temp = tempnam(sys_get_temp_dir(), 'santakani-image-download-');
                file_put_contents($temp, fopen("https://source.unsplash.com/random", 'r'));
                $size = getimagesize($temp);
                $image->mime_type = $size['mime'];
                $image->width = $size[0];
                $image->height = $size[1];
                $image->weight = rand(1,255);
                $image->save();
                $image->saveFile($temp);

                $designer->images()->save($image);

                sleep(3); // Avoid downloading the same image because of HTTP cache
            }
        });
    }
}
