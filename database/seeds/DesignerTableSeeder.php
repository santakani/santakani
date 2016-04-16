<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class DesignerTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('designer')->insert([
            'country_id' => 1,
            'city_id' => 1,
            'image_id' => 13,
            'user_id' => 1,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('designer_translation')->insert([
            'designer_id' => 1,
            'locale' => 'en',
            'name' => '2OR+BYYAT',
            'content' => <<<TEXT
2OR+BYYAT is a young, original and dynamic fashion brand based in Helsinki, Finland. The label is known for skillful unconventional cutting, poetic story of colours and inventive textures as well as high quality leather bags. Products are well made and a lot of attention is paid to details. The key factors of the 2OR+BYYAT philosophy are creativity in symbiosis with wearability. The clothes are eclectic but they stand the test of time; the designs are made to last.

The highly acclaimed fashion brand was established in Helsinki, Finland, in 2002 by brand’s creative design director YAT.

The brand name reflects the fact that in order to create and evolve in the nature, two or more elements are required. No wonder, YAT derives inspiration from the nature for his designs year after year. The brand name is pronounced ʻTwo or plus by YATʼ.

2OR+BYYAT has one flagship store in Fredrikinkatu 35, 00120 Helsinki.
TEXT
            ,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('designer_translation')->insert([
            'designer_id' => 1,
            'locale' => 'zh',
            'name' => '2OR+BYYAT',
            'content' => <<<TEXT
2OR+BYYAT 是一个来自芬兰赫尔辛基的时尚品牌，年轻，富有原创性，动态的。标签是著名的熟练非常规切割，颜色和纹理的发明故事诗意，以及高品质的皮包。产品制作精良，很多重视细节。在2OR+ BYYAT哲学的关键因素是与耐磨性共生的创造力。衣服是不拘一格的，但他们经得起时间的考验;这些设计都是为了持续。

广受赞誉的时尚品牌是由品牌的创意设计总监 YAT 成立于芬兰首都赫尔辛基，于2002年。

品牌名称反映了为了创建和在自然界中进化，需要两个或更多个元件的事实。难怪，逸年复一年衍生灵感来自大自然，他的设计。品牌名称是由YAT'明显'Two或加。

2OR+ BYYAT 的旗舰店位于 Fredrikinkatu 35，00120 赫尔辛基。
TEXT
            ,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('designer')->insert([
            'image_id' => 2,
            'user_id' => 2,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

         DB::table('designer_translation')->insert([
            'designer_id' => 2,
            'locale' => 'en',
            'name' => 'Du Yuexin',
            'content' => file_get_contents('http://loripsum.net/api'),
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('designer_translation')->insert([
            'designer_id' => 2,
            'locale' => 'zh',
            'name' => '杜玥辛',
            'content' => file_get_contents('http://loripsum.net/api'),
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('designer')->insert([
            'image_id' => 3,
            'user_id' => 3,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

         DB::table('designer_translation')->insert([
            'designer_id' => 3,
            'locale' => 'en',
            'name' => 'Yun Xiaotong',
            'content' => file_get_contents('http://loripsum.net/api'),
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('designer_translation')->insert([
            'designer_id' => 3,
            'locale' => 'zh',
            'name' => '云小童',
            'content' => file_get_contents('http://loripsum.net/api'),
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('designer')->insert([
            'image_id' => 4,
            'user_id' => 1,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

         DB::table('designer_translation')->insert([
            'designer_id' => 4,
            'locale' => 'en',
            'name' => 'Yu Huiyang',
            'content' => file_get_contents('http://loripsum.net/api'),
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('designer_translation')->insert([
            'designer_id' => 4,
            'locale' => 'zh',
            'name' => '余慧阳',
            'content' => file_get_contents('http://loripsum.net/api'),
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
    }
}
