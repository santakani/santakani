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
 * CreateCityTable
 *
 * Database migration to create "city" and "city_translation" table.
 *
 * @author Guo Yunhe <guoyunhebrave@gmail.com>
 * @see https://github.com/santakani/santakani.com/wiki/City
 */
class CreateCityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('city', function (Blueprint $table) {
            $table->increments('id');

            $table->string('slug');
            $table->integer('country_id')->unsigned()->nullable();
            $table->integer('image_id')->unsigned()->nullable();
            $table->float('latitude', 10, 6)->nullable();
            $table->float('longitude', 10, 6)->nullable();
            $table->string('timezone'); // "Europe/Helsinki", "Asia/Shanghai"

            $table->timestamps();
            $table->softDeletes();

            $table->unique(['country_id', 'slug']);
            $table->index(['latitude', 'longitude']);

            $table->foreign('country_id')->references('id')->on('country')->onDelete('set null');
            $table->foreign('image_id')->references('id')->on('image')->onDelete('set null');
        });

        Schema::create('city_translation', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('city_id')->unsigned();
            $table->string('locale'); // ISO 639-1 (2 letters)

            $table->string('name')->nullable();
            $table->text('content')->nullable(); // HTML

            $table->timestamps();

            $table->unique(['city_id','locale']);

            $table->foreign('city_id')->references('id')->on('city')->onDelete('cascade');
        });

        DB::statement('ALTER TABLE city_translation ADD FULLTEXT INDEX city_translation_name_ft_index(name)');
        DB::statement('ALTER TABLE city_translation ADD FULLTEXT INDEX city_translation_content_ft_index(content)');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('city_translation');

        Schema::drop('city');
    }
}
