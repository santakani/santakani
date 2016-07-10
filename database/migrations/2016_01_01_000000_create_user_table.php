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

            $table->string('name');
            $table->string('description')->nullable();

            $table->string('email')->nullable()->unique();
            $table->string('password', 60)->nullable();
            $table->rememberToken();
            $table->string('api_token', 60)->unique();

            $table->string('facebook_id')->nullable()->unique();
            $table->string('google_id')->nullable()->unique();
            $table->string('twitter_id')->nullable()->unique();

            $table->string('locale')->nullable();
            $table->string('role')->nullable();

            $table->timestamp('avatar_uploaded_at')->nullable();
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
