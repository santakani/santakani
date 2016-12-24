<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(App\User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'description' => $faker->text,
        'email' => $faker->email,
        'password' => bcrypt(str_random(10)),
        'api_token' => str_random(60),
    ];
});

$factory->define(App\Tag::class, function (Faker\Generator $faker) {
    return [
        'level' => rand(150,255),
        'like_count' => rand(0,50),
    ];
});

$factory->define(App\TagTranslation::class, function (Faker\Generator $faker) {
    return [
        'locale' => 'en',
        'name' => $faker->word,
        'alias' => implode(',', $faker->words),
        'description' => $faker->text,
    ];
});

$factory->define(App\Designer::class, function (Faker\Generator $faker) {
    return [
        'email' => $faker->email,
        'website' => $faker->url,
        'facebook' => 'https://www.facebook.com/',
        'instagram' => 'https://www.instagram.com/',
        'pinterest' => 'https://www.pinterest.com/',
        'youtube' => 'https://www.youtube.com/',
        'vimeo' => 'https://www.vimeo.com/',
        'like_count' => rand(0,200),
    ];
});

$factory->define(App\DesignerTranslation::class, function (Faker\Generator $faker) {
    return [
        'locale' => 'en',
        'name' => $faker->name,
        'tagline' => $faker->sentence,
        'content' => file_get_contents('http://loripsum.net/api/'.intval(rand(3,15))),
    ];
});
