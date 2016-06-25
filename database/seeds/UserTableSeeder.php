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
        DB::table('user')->insert([
            'name' => 'Guo Yunhe',
            'email' => 'yunhe.guo@example.com',
            'password' => bcrypt('abcd123456'),
            'api_token' => str_random(60),
            'role' => 'admin',
        ]);

        DB::table('user')->insert([
            'name' => 'Du Yuexin',
            'email' => 'yuexin.du@example.com',
            'password' => bcrypt('abcd123456'),
            'api_token' => str_random(60),
            'role' => 'editor',
        ]);

        DB::table('user')->insert([
            'name' => 'Yun Xiaotong',
            'email' => 'xiaotong.yun@example.com',
            'password' => bcrypt('abcd123456'),
            'api_token' => str_random(60),
        ]);
    }
}
