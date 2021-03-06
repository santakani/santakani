<?php

/*
 * This file is part of Santakani
 *
 * (c) Guo Yunhe <guoyunhebrave@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

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

            $table->string('type');

            $table->integer('image_id')->unsigned()->nullable();

            $table->integer('city_id')->unsigned()->nullable();
            $table->string('address')->nullable();
            $table->float('latitude', 10, 6)->nullable();
            $table->float('longitude', 10, 6)->nullable();

            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('website')->nullable();
            $table->string('facebook')->nullable();
            $table->string('google_plus')->nullable();

            $table->integer('user_id')->unsigned()->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->index(['latitude', 'longitude']);

            $table->foreign('city_id')->references('id')->on('city')->onDelete('set null');
            $table->foreign('image_id')->references('id')->on('image')->onDelete('set null');
            $table->foreign('user_id')->references('id')->on('user')->onDelete('set null');
        });

        Schema::create('place_translation', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('place_id')->unsigned();
            $table->string('locale');

            $table->string('name')->nullable();
            $table->text('content')->nullable();

            $table->timestamps();

            $table->unique(['place_id','locale']);

            $table->foreign('place_id')->references('id')->on('place')->onDelete('cascade');
        });

        DB::statement('ALTER TABLE place_translation ADD FULLTEXT INDEX place_translation_name_ft_index(name)');
        DB::statement('ALTER TABLE place_translation ADD FULLTEXT INDEX place_translation_content_ft_index(content)');
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
