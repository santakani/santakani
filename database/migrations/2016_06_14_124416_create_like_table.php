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
 * CreateLikeTable
 *
 * Database migration to create "like" and "like_count" table.
 *
 * @author Guo Yunhe <guoyunhebrave@gmail.com>
 * @see https://github.com/santakani/santakani.com/wiki/Like
 */
class CreateLikeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('like', function (Blueprint $table) {
            $table->increments('id');

            $table->string('likeable_type');
            $table->integer('likeable_id')->unsigned();
            $table->integer('user_id')->unsigned();

            $table->timestamps();

            $table->unique(['likeable_type', 'likeable_id', 'user_id']);

            $table->foreign('user_id')->references('id')->on('user')->onDelete('cascade');
        });

        Schema::create('like_count', function (Blueprint $table) {
            $table->increments('id');

            $table->string('likeable_type');
            $table->integer('likeable_id')->unsigned();
            $table->integer('count')->unsigned()->default(0);

            $table->timestamps();

            $table->unique(['likeable_type', 'likeable_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('like_count');

        Schema::drop('like');
    }
}
