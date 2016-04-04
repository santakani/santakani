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
            'image_id' => 1,
            'user_id' => 1,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('designer_translation')->insert([
            'designer_id' => 1,
            'locale' => 'en',
            'name' => 'Guo Yunhe',
            'content' => <<<HTML
Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris varius commodo ante, et gravida massa gravida sed. Quisque aliquet orci vitae justo commodo, eu hendrerit justo euismod. Morbi non eleifend magna, eu cursus nulla. Integer pulvinar quam non velit gravida lacinia. Nullam commodo volutpat lectus, sed cursus enim tincidunt id. Pellentesque aliquet, arcu mollis porta pellentesque, ligula justo rhoncus mi, non aliquam mi ex ut velit. Donec ac sapien nec lorem fermentum viverra non et nisi. Aenean iaculis aliquet pharetra. Vivamus consectetur turpis sit amet sagittis aliquam. Ut placerat tellus eu enim aliquam, at faucibus mauris tempor. Proin at ullamcorper eros. Aliquam eget vulputate metus, vel dictum ligula. Vivamus id quam porttitor, bibendum lorem id, posuere quam.

Fusce nec velit quam. Morbi viverra lacus dignissim aliquet luctus. Sed vel dictum nisi. Aliquam in neque nisl. Sed quis metus eu lorem lobortis euismod sit amet ut velit. Donec in gravida tellus. In at hendrerit lacus. Nunc vestibulum tincidunt augue, at semper odio varius in. Fusce congue laoreet tellus, sed malesuada mi tristique ut.

Nullam aliquam ac nibh et fermentum. Etiam efficitur convallis mollis. Maecenas volutpat augue at ipsum aliquam rutrum. Sed tempus volutpat dictum. Duis in ante tellus. Aliquam ipsum ex, condimentum ac tellus sit amet, volutpat varius metus. Sed sollicitudin mauris ut tincidunt volutpat. Proin urna ipsum, facilisis in pellentesque et, feugiat vel dolor. In hac habitasse platea dictumst. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Sed eu velit dolor. Sed id vulputate augue. Aliquam id elit quis libero vulputate dictum non quis est. Nunc ut est id arcu lacinia blandit. Curabitur massa augue, placerat eu blandit vitae, lacinia sed metus. Cras lacinia, lacus a viverra fermentum, lorem metus viverra enim, a pharetra justo purus in massa.

Praesent iaculis ligula eu porttitor rhoncus. Curabitur at pellentesque erat. Ut ultricies lectus eget egestas aliquam. Nunc sed velit euismod, ullamcorper urna ac, tempus orci. Maecenas nec purus et purus fringilla accumsan mollis quis lectus. Vestibulum congue, urna vitae condimentum malesuada, lorem odio facilisis eros, ut pulvinar risus leo sed ante. Praesent porttitor urna nec augue euismod tristique. Aliquam a sem ac nisl lacinia condimentum id nec nibh. Vivamus at interdum sapien. Vestibulum convallis dapibus nulla nec varius. Etiam est turpis, dictum id ipsum ut, eleifend venenatis quam. Fusce tincidunt placerat tortor at maximus. Integer eget posuere diam. Maecenas feugiat, ipsum eu ultrices tempor, metus leo pharetra purus, a dignissim tortor felis vel arcu. Morbi non quam at turpis laoreet ornare nec at purus. Maecenas vehicula nulla at sollicitudin auctor.

In faucibus urna ut erat blandit elementum. Nulla at erat at massa facilisis molestie. Nam ut tellus ligula. Cras gravida malesuada magna, sit amet posuere erat dictum ultrices. Nunc nunc risus, rutrum eu tempor et, ultrices sit amet lacus. Sed ultricies accumsan dui a tempor. Ut ac orci eget est aliquet vulputate. Etiam consequat diam neque, in dapibus dui hendrerit ac. Sed elementum velit at ligula sollicitudin accumsan non id nisi.
HTML
,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('designer_translation')->insert([
            'designer_id' => 1,
            'locale' => 'zh',
            'name' => '郭云鹤',
            'content' => <<<HTML
别统始太性积老马克，听给南为通片海立，第常Q雨佣例政。 入局她般支龙，目重候社属务，么录W么。 百多改育先教路水并，数众车六处志线内层，众医少事肃行花。

快型建此动问没铁为几了任件机，小发确须动度M族励非肃满。 界争治内论强具常解，文率解则四口和条强，期弦告个带参求。 张没都外论品向知，种果象接与江被，E杏杏经投。 响史万现山组观次头王，然为与取料始因书热，民提8部D呀数我。

样入民长满空百见型，事全老铁一形接记质，具9X作S被几。 术日科器适心属叫米切，运意气历选深地四强，何律村头两A述布乱。 部除际从很务也参，被节油明员龙，局路屈得医更。

族取识老什带心间广太运，易走又白解给合省酸何，育书肃劳型发听今转。 受更江们样速集，员维志值民省即，少A伶枣听。

领她活常意南果力接增县，式总四月儿维和革常山，光把届有段石专赚辅。
HTML
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
            'content' => <<<HTML
Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris varius commodo ante, et gravida massa gravida sed. Quisque aliquet orci vitae justo commodo, eu hendrerit justo euismod. Morbi non eleifend magna, eu cursus nulla. Integer pulvinar quam non velit gravida lacinia. Nullam commodo volutpat lectus, sed cursus enim tincidunt id. Pellentesque aliquet, arcu mollis porta pellentesque, ligula justo rhoncus mi, non aliquam mi ex ut velit. Donec ac sapien nec lorem fermentum viverra non et nisi. Aenean iaculis aliquet pharetra. Vivamus consectetur turpis sit amet sagittis aliquam. Ut placerat tellus eu enim aliquam, at faucibus mauris tempor. Proin at ullamcorper eros. Aliquam eget vulputate metus, vel dictum ligula. Vivamus id quam porttitor, bibendum lorem id, posuere quam.

Fusce nec velit quam. Morbi viverra lacus dignissim aliquet luctus. Sed vel dictum nisi. Aliquam in neque nisl. Sed quis metus eu lorem lobortis euismod sit amet ut velit. Donec in gravida tellus. In at hendrerit lacus. Nunc vestibulum tincidunt augue, at semper odio varius in. Fusce congue laoreet tellus, sed malesuada mi tristique ut.

Nullam aliquam ac nibh et fermentum. Etiam efficitur convallis mollis. Maecenas volutpat augue at ipsum aliquam rutrum. Sed tempus volutpat dictum. Duis in ante tellus. Aliquam ipsum ex, condimentum ac tellus sit amet, volutpat varius metus. Sed sollicitudin mauris ut tincidunt volutpat. Proin urna ipsum, facilisis in pellentesque et, feugiat vel dolor. In hac habitasse platea dictumst. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Sed eu velit dolor. Sed id vulputate augue. Aliquam id elit quis libero vulputate dictum non quis est. Nunc ut est id arcu lacinia blandit. Curabitur massa augue, placerat eu blandit vitae, lacinia sed metus. Cras lacinia, lacus a viverra fermentum, lorem metus viverra enim, a pharetra justo purus in massa.

Praesent iaculis ligula eu porttitor rhoncus. Curabitur at pellentesque erat. Ut ultricies lectus eget egestas aliquam. Nunc sed velit euismod, ullamcorper urna ac, tempus orci. Maecenas nec purus et purus fringilla accumsan mollis quis lectus. Vestibulum congue, urna vitae condimentum malesuada, lorem odio facilisis eros, ut pulvinar risus leo sed ante. Praesent porttitor urna nec augue euismod tristique. Aliquam a sem ac nisl lacinia condimentum id nec nibh. Vivamus at interdum sapien. Vestibulum convallis dapibus nulla nec varius. Etiam est turpis, dictum id ipsum ut, eleifend venenatis quam. Fusce tincidunt placerat tortor at maximus. Integer eget posuere diam. Maecenas feugiat, ipsum eu ultrices tempor, metus leo pharetra purus, a dignissim tortor felis vel arcu. Morbi non quam at turpis laoreet ornare nec at purus. Maecenas vehicula nulla at sollicitudin auctor.

In faucibus urna ut erat blandit elementum. Nulla at erat at massa facilisis molestie. Nam ut tellus ligula. Cras gravida malesuada magna, sit amet posuere erat dictum ultrices. Nunc nunc risus, rutrum eu tempor et, ultrices sit amet lacus. Sed ultricies accumsan dui a tempor. Ut ac orci eget est aliquet vulputate. Etiam consequat diam neque, in dapibus dui hendrerit ac. Sed elementum velit at ligula sollicitudin accumsan non id nisi.
HTML
,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('designer_translation')->insert([
            'designer_id' => 2,
            'locale' => 'zh',
            'name' => '杜玥辛',
            'content' => <<<HTML
别统始太性积老马克，听给南为通片海立，第常Q雨佣例政。 入局她般支龙，目重候社属务，么录W么。 百多改育先教路水并，数众车六处志线内层，众医少事肃行花。

快型建此动问没铁为几了任件机，小发确须动度M族励非肃满。 界争治内论强具常解，文率解则四口和条强，期弦告个带参求。 张没都外论品向知，种果象接与江被，E杏杏经投。 响史万现山组观次头王，然为与取料始因书热，民提8部D呀数我。

样入民长满空百见型，事全老铁一形接记质，具9X作S被几。 术日科器适心属叫米切，运意气历选深地四强，何律村头两A述布乱。 部除际从很务也参，被节油明员龙，局路屈得医更。

族取识老什带心间广太运，易走又白解给合省酸何，育书肃劳型发听今转。 受更江们样速集，员维志值民省即，少A伶枣听。

领她活常意南果力接增县，式总四月儿维和革常山，光把届有段石专赚辅。
HTML
,
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
            'content' => <<<HTML
Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris varius commodo ante, et gravida massa gravida sed. Quisque aliquet orci vitae justo commodo, eu hendrerit justo euismod. Morbi non eleifend magna, eu cursus nulla. Integer pulvinar quam non velit gravida lacinia. Nullam commodo volutpat lectus, sed cursus enim tincidunt id. Pellentesque aliquet, arcu mollis porta pellentesque, ligula justo rhoncus mi, non aliquam mi ex ut velit. Donec ac sapien nec lorem fermentum viverra non et nisi. Aenean iaculis aliquet pharetra. Vivamus consectetur turpis sit amet sagittis aliquam. Ut placerat tellus eu enim aliquam, at faucibus mauris tempor. Proin at ullamcorper eros. Aliquam eget vulputate metus, vel dictum ligula. Vivamus id quam porttitor, bibendum lorem id, posuere quam.

Fusce nec velit quam. Morbi viverra lacus dignissim aliquet luctus. Sed vel dictum nisi. Aliquam in neque nisl. Sed quis metus eu lorem lobortis euismod sit amet ut velit. Donec in gravida tellus. In at hendrerit lacus. Nunc vestibulum tincidunt augue, at semper odio varius in. Fusce congue laoreet tellus, sed malesuada mi tristique ut.

Nullam aliquam ac nibh et fermentum. Etiam efficitur convallis mollis. Maecenas volutpat augue at ipsum aliquam rutrum. Sed tempus volutpat dictum. Duis in ante tellus. Aliquam ipsum ex, condimentum ac tellus sit amet, volutpat varius metus. Sed sollicitudin mauris ut tincidunt volutpat. Proin urna ipsum, facilisis in pellentesque et, feugiat vel dolor. In hac habitasse platea dictumst. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Sed eu velit dolor. Sed id vulputate augue. Aliquam id elit quis libero vulputate dictum non quis est. Nunc ut est id arcu lacinia blandit. Curabitur massa augue, placerat eu blandit vitae, lacinia sed metus. Cras lacinia, lacus a viverra fermentum, lorem metus viverra enim, a pharetra justo purus in massa.

Praesent iaculis ligula eu porttitor rhoncus. Curabitur at pellentesque erat. Ut ultricies lectus eget egestas aliquam. Nunc sed velit euismod, ullamcorper urna ac, tempus orci. Maecenas nec purus et purus fringilla accumsan mollis quis lectus. Vestibulum congue, urna vitae condimentum malesuada, lorem odio facilisis eros, ut pulvinar risus leo sed ante. Praesent porttitor urna nec augue euismod tristique. Aliquam a sem ac nisl lacinia condimentum id nec nibh. Vivamus at interdum sapien. Vestibulum convallis dapibus nulla nec varius. Etiam est turpis, dictum id ipsum ut, eleifend venenatis quam. Fusce tincidunt placerat tortor at maximus. Integer eget posuere diam. Maecenas feugiat, ipsum eu ultrices tempor, metus leo pharetra purus, a dignissim tortor felis vel arcu. Morbi non quam at turpis laoreet ornare nec at purus. Maecenas vehicula nulla at sollicitudin auctor.

In faucibus urna ut erat blandit elementum. Nulla at erat at massa facilisis molestie. Nam ut tellus ligula. Cras gravida malesuada magna, sit amet posuere erat dictum ultrices. Nunc nunc risus, rutrum eu tempor et, ultrices sit amet lacus. Sed ultricies accumsan dui a tempor. Ut ac orci eget est aliquet vulputate. Etiam consequat diam neque, in dapibus dui hendrerit ac. Sed elementum velit at ligula sollicitudin accumsan non id nisi.
HTML
,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('designer_translation')->insert([
            'designer_id' => 3,
            'locale' => 'zh',
            'name' => '云小童',
            'content' => <<<HTML
别统始太性积老马克，听给南为通片海立，第常Q雨佣例政。 入局她般支龙，目重候社属务，么录W么。 百多改育先教路水并，数众车六处志线内层，众医少事肃行花。

快型建此动问没铁为几了任件机，小发确须动度M族励非肃满。 界争治内论强具常解，文率解则四口和条强，期弦告个带参求。 张没都外论品向知，种果象接与江被，E杏杏经投。 响史万现山组观次头王，然为与取料始因书热，民提8部D呀数我。

样入民长满空百见型，事全老铁一形接记质，具9X作S被几。 术日科器适心属叫米切，运意气历选深地四强，何律村头两A述布乱。 部除际从很务也参，被节油明员龙，局路屈得医更。

族取识老什带心间广太运，易走又白解给合省酸何，育书肃劳型发听今转。 受更江们样速集，员维志值民省即，少A伶枣听。

领她活常意南果力接增县，式总四月儿维和革常山，光把届有段石专赚辅。
HTML
,
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
            'content' => <<<HTML
Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris varius commodo ante, et gravida massa gravida sed. Quisque aliquet orci vitae justo commodo, eu hendrerit justo euismod. Morbi non eleifend magna, eu cursus nulla. Integer pulvinar quam non velit gravida lacinia. Nullam commodo volutpat lectus, sed cursus enim tincidunt id. Pellentesque aliquet, arcu mollis porta pellentesque, ligula justo rhoncus mi, non aliquam mi ex ut velit. Donec ac sapien nec lorem fermentum viverra non et nisi. Aenean iaculis aliquet pharetra. Vivamus consectetur turpis sit amet sagittis aliquam. Ut placerat tellus eu enim aliquam, at faucibus mauris tempor. Proin at ullamcorper eros. Aliquam eget vulputate metus, vel dictum ligula. Vivamus id quam porttitor, bibendum lorem id, posuere quam.

Fusce nec velit quam. Morbi viverra lacus dignissim aliquet luctus. Sed vel dictum nisi. Aliquam in neque nisl. Sed quis metus eu lorem lobortis euismod sit amet ut velit. Donec in gravida tellus. In at hendrerit lacus. Nunc vestibulum tincidunt augue, at semper odio varius in. Fusce congue laoreet tellus, sed malesuada mi tristique ut.

Nullam aliquam ac nibh et fermentum. Etiam efficitur convallis mollis. Maecenas volutpat augue at ipsum aliquam rutrum. Sed tempus volutpat dictum. Duis in ante tellus. Aliquam ipsum ex, condimentum ac tellus sit amet, volutpat varius metus. Sed sollicitudin mauris ut tincidunt volutpat. Proin urna ipsum, facilisis in pellentesque et, feugiat vel dolor. In hac habitasse platea dictumst. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Sed eu velit dolor. Sed id vulputate augue. Aliquam id elit quis libero vulputate dictum non quis est. Nunc ut est id arcu lacinia blandit. Curabitur massa augue, placerat eu blandit vitae, lacinia sed metus. Cras lacinia, lacus a viverra fermentum, lorem metus viverra enim, a pharetra justo purus in massa.

Praesent iaculis ligula eu porttitor rhoncus. Curabitur at pellentesque erat. Ut ultricies lectus eget egestas aliquam. Nunc sed velit euismod, ullamcorper urna ac, tempus orci. Maecenas nec purus et purus fringilla accumsan mollis quis lectus. Vestibulum congue, urna vitae condimentum malesuada, lorem odio facilisis eros, ut pulvinar risus leo sed ante. Praesent porttitor urna nec augue euismod tristique. Aliquam a sem ac nisl lacinia condimentum id nec nibh. Vivamus at interdum sapien. Vestibulum convallis dapibus nulla nec varius. Etiam est turpis, dictum id ipsum ut, eleifend venenatis quam. Fusce tincidunt placerat tortor at maximus. Integer eget posuere diam. Maecenas feugiat, ipsum eu ultrices tempor, metus leo pharetra purus, a dignissim tortor felis vel arcu. Morbi non quam at turpis laoreet ornare nec at purus. Maecenas vehicula nulla at sollicitudin auctor.

In faucibus urna ut erat blandit elementum. Nulla at erat at massa facilisis molestie. Nam ut tellus ligula. Cras gravida malesuada magna, sit amet posuere erat dictum ultrices. Nunc nunc risus, rutrum eu tempor et, ultrices sit amet lacus. Sed ultricies accumsan dui a tempor. Ut ac orci eget est aliquet vulputate. Etiam consequat diam neque, in dapibus dui hendrerit ac. Sed elementum velit at ligula sollicitudin accumsan non id nisi.
HTML
,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('designer_translation')->insert([
            'designer_id' => 4,
            'locale' => 'zh',
            'name' => '余慧阳',
            'content' => <<<HTML
别统始太性积老马克，听给南为通片海立，第常Q雨佣例政。 入局她般支龙，目重候社属务，么录W么。 百多改育先教路水并，数众车六处志线内层，众医少事肃行花。

快型建此动问没铁为几了任件机，小发确须动度M族励非肃满。 界争治内论强具常解，文率解则四口和条强，期弦告个带参求。 张没都外论品向知，种果象接与江被，E杏杏经投。 响史万现山组观次头王，然为与取料始因书热，民提8部D呀数我。

样入民长满空百见型，事全老铁一形接记质，具9X作S被几。 术日科器适心属叫米切，运意气历选深地四强，何律村头两A述布乱。 部除际从很务也参，被节油明员龙，局路屈得医更。

族取识老什带心间广太运，易走又白解给合省酸何，育书肃劳型发听今转。 受更江们样速集，员维志值民省即，少A伶枣听。

领她活常意南果力接增县，式总四月儿维和革常山，光把届有段石专赚辅。
HTML
,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
    }
}
