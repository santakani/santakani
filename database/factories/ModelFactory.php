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
        'tag_id' => rand(0,50),
        'locale' => 'en',
        'name' => $faker->word,
        'alias' => implode(',', $faker->words),
        'description' => $faker->text,
    ];
});
