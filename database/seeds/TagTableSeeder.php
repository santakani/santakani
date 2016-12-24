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
 * TagTableSeeder
 *
 * Fill test data into "tag" and "tag_translation" table.
 *
 * @author Guo Yunhe <guoyunhebrave@gmail.com>
 * @see https://github.com/santakani/santakani.com/wiki/Tag
 * @see https://github.com/santakani/santakani.com/wiki/Test-Data
 */
class TagTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tags = factory(App\Tag::class, 50)->create()->each(function ($tag) {
            $tag->translations()->save(factory(App\TagTranslation::class)->make());

            $image = new App\Image();
            $temp = tempnam(sys_get_temp_dir(), 'santakani-image-download-');
            file_put_contents($temp, fopen("https://source.unsplash.com/category/objects", 'r'));
            $size = getimagesize($temp);
            $image->mime_type = $size['mime'];
            $image->width = $size[0];
            $image->height = $size[1];
            $image->save();
            $image->saveFile($temp);

            $tag->image()->associate($image);
            $tag->save();
            $tag->images()->save($image);

            sleep(3); // Avoid downloading the same image because HTTP cache
        });
    }
}
