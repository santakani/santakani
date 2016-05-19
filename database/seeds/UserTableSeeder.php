<?php

use Illuminate\Database\Seeder;

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
        ]);

        DB::table('user')->insert([
            'name' => 'Du Yuexin',
            'email' => 'yuexin.du@example.com',
            'password' => bcrypt('abcd123456'),
        ]);

        DB::table('user')->insert([
            'name' => 'Yun Xiaotong',
            'email' => 'xiaotong.yun@example.com',
            'password' => bcrypt('abcd123456'),
        ]);
    }
}
