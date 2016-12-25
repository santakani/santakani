<?php

use Carbon\Carbon;

use Illuminate\Database\Seeder;

class DesignTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $designers = App\Designer::all();

        $designers->each(function ($designer) {
            $n1 = intval(rand(0,10));

            for ($i1 = 0; $i1 < $n1; $i1++) {
                $design = factory(App\Design::class)->make();
                $designer->designs()->save($design);
                $designer->user->designs()->save($design);
                $design->translations()->save(factory(App\DesignTranslation::class)->make());

                // Download cover image
                $image = new App\Image();
                $temp = tempnam(sys_get_temp_dir(), 'santakani-image-download-');
                file_put_contents($temp, fopen("https://source.unsplash.com/category/objects", 'r'));
                $size = getimagesize($temp);
                $image->mime_type = $size['mime'];
                $image->width = $size[0];
                $image->height = $size[1];
                $image->weight = 255;
                $image->save();
                $image->saveFile($temp);

                $design->image()->associate($image);
                $design->save();
                $design->images()->save($image);

                sleep(3); // Avoid downloading the same image because of HTTP cache

                // Download gallery images

                $n2 = rand(0, 10);

                for ($i2 = 0; $i2 < $n2; $i2++) {
                    $image = new App\Image();
                    $temp = tempnam(sys_get_temp_dir(), 'santakani-image-download-');
                    file_put_contents($temp, fopen("https://source.unsplash.com/category/objects", 'r'));
                    $size = getimagesize($temp);
                    $image->mime_type = $size['mime'];
                    $image->width = $size[0];
                    $image->height = $size[1];
                    $image->weight = rand(1,255);
                    $image->save();
                    $image->saveFile($temp);

                    $design->images()->save($image);

                    sleep(3); // Avoid downloading the same image because of HTTP cache
                }

                $n3 = rand(1, 10);

                $tags = App\Tag::take(intval($n3))->orderByRaw('RAND()')->get();

                for ($i3 = 0; $i3 < $n3; $i3++) {
                    $design->tags()->attach($tags->pop()->id);
                }
            }
        });
    }
}
