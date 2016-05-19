<?php

use Illuminate\Database\Seeder;

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
