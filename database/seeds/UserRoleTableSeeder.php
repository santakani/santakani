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
 * UserRoleTableSeeder
 *
 * Fill test data into "user_role" table.
 *
 * @author Guo Yunhe <guoyunhebrave@gmail.com>
 * @see https://github.com/santakani/santakani.com/wiki/User
 * @see https://github.com/santakani/santakani.com/wiki/Test-Data
 */
class UserRoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user_roles = [
            [1, 'admin'],
            [1, 'editor'],
            [1, 'translator-zh'],

            [2, 'editor'],
            [2, 'translator-zh'],

            [3, 'translator-de'],
            [3, 'translator-ja'],
        ];

        foreach ($user_roles as $user_role) {
            DB::table('user_role')->insert([
                'user_id' => $user_role[0],
                'role' => $user_role[1],
            ]);
        }

    }
}
