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
        DB::table('user_role')->insert([
            'user_id' => 1,
            'role' => 'admin',
        ]);
        DB::table('user_role')->insert([
            'user_id' => 1,
            'role' => 'editor',
        ]);
        DB::table('user_role')->insert([
            'user_id' => 1,
            'role' => 'translator',
        ]);
    }
}
