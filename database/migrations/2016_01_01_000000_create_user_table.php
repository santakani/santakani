<?php

/*
 * This file is part of santakani.com
 *
 * (c) Guo Yunhe <guoyunhebrave@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * CreateUserTable
 *
 * Database migration to create "user" table. This table control user auth and
 * settings.
 *
 * @author Guo Yunhe <guoyunhebrave@gmail.com>
 * @see https://github.com/santakani/santakani.com/wiki/User
 */

class CreateUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user', function (Blueprint $table) {
            $table->increments('id');

            $table->string('name'); // Display name, not unique, not used for login
            $table->text('description'); // Plain text

            $table->string('email')->unique(); // As username used for login
            $table->string('password', 60);
            $table->rememberToken();
            $table->string('api_token', 60)->unique();

            $table->timestamps();
            $table->softDeletes();
        });

        DB::statement('ALTER TABLE user ADD FULLTEXT INDEX user_name_ft_index(name)');
        DB::statement('ALTER TABLE user ADD FULLTEXT INDEX user_description_ft_index(description)');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('user');
    }
}
