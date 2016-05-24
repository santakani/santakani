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
 * CreatePlaceTable
 *
 * Database migration to create "place" and "place_translation" table.
 *
 * @author Guo Yunhe <guoyunhebrave@gmail.com>
 * @see https://github.com/santakani/santakani.com/wiki/Place
 */
class CreatePlaceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('place', function (Blueprint $table) {
            $table->increments('id');

            $table->string('type'); // shop, showroom, studio, school, etc.

            $table->integer('country_id')->unsigned()->nullable();
            $table->integer('city_id')->unsigned()->nullable();
            $table->integer('image_id')->unsigned()->nullable();
            $table->integer('user_id')->unsigned()->nullable();

            $table->string('address');

            $table->string('email');
            $table->string('phone');
            $table->string('website');
            $table->string('facebook'); // Facebook page
            $table->string('google_plus'); // Google+ business page

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('country_id')->references('id')->on('country')->onDelete('set null');
            $table->foreign('city_id')->references('id')->on('city')->onDelete('set null');
            $table->foreign('image_id')->references('id')->on('image')->onDelete('set null');
            $table->foreign('user_id')->references('id')->on('user')->onDelete('set null');
        });

        DB::statement('ALTER TABLE place ADD coordinate POINT AFTER address' );

        Schema::create('place_translation', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('place_id')->unsigned();
            $table->string('locale');

            $table->string('name');
            $table->text('content');

            $table->timestamps();

            $table->unique(['place_id','locale']);

            $table->foreign('place_id')->references('id')->on('place')->onDelete('cascade');
        });

        DB::statement('ALTER TABLE place_translation ADD FULLTEXT INDEX place_translation_name_index(name)');
        DB::statement('ALTER TABLE place_translation ADD FULLTEXT INDEX place_translation_content_index(content)');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('place_translation');

        Schema::drop('place');
    }
}
