<?php

/*
 * This file is part of Santakani
 *
 * (c) Guo Yunhe <guoyunhebrave@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Carbon\Carbon;
use Illuminate\Database\Seeder;

/**
 * UserTableSeeder
 *
 * Fill test data into "user" table.
 *
 * @author Guo Yunhe <guoyunhebrave@gmail.com>
 * @see https://github.com/santakani/santakani.com/wiki/User
 * @see https://github.com/santakani/santakani.com/wiki/Test-Data
 */
class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        $admin = App\User::create([
            'name' => 'Admin Rabbit',
            'description' => $faker->text,
            'email' => 'admin@example.com',
            'password' => bcrypt('abcd123456'),
            'api_token' => str_random(60),
        ]);
        $admin->role = 'admin';
        $admin->save();

        $faker = Faker\Factory::create();
        $editor = App\User::create([
            'name' => 'Editor Panda',
            'description' => $faker->text,
            'email' => 'editor@example.com',
            'password' => bcrypt('abcd123456'),
            'api_token' => str_random(60),
            'role' => 'editor',
        ]);
        $editor->role = 'editor';
        $editor->save();

        $faker = Faker\Factory::create();
        $user = App\User::create([
            'name' => 'User Doge',
            'description' => $faker->text,
            'email' => 'user@example.com',
            'password' => bcrypt('abcd123456'),
            'api_token' => str_random(60),
        ]);

        $users = factory(App\User::class, 47)->create();

        $users->push($admin);
        $users->push($editor);
        $users->push($user);

        foreach ($users as $user) {
            $user->avatar_uploaded_at = Carbon::now();
            $user->save();
            $temp = tempnam(sys_get_temp_dir(), 'santakani-avatar-download-');
            file_put_contents($temp, fopen("https://source.unsplash.com/category/people/300x300", 'r'));
            $user->saveAvatarFile($temp);
            sleep(3); // Avoid downloading the same image because HTTP cache
        }
    }
}
