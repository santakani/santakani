<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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

            // Non-translated content
            $table->integer('country_id')->unsigned()->nullable(); // ID of country
            $table->integer('city_id')->unsigned()->nullable(); // ID of city
            $table->integer('image_id')->unsigned()->nullable(); // ID of image
            $table->string('type'); // Shop, gallery, studio, etc.
            $table->string('address');
            $table->string('email');
            $table->string('phone');
            $table->integer('user_id')->unsigned()->nullable(); // Who own this place page

            // Timestamps
            $table->timestamps();
            $table->softDeletes();

            // Foreign keys, when delete country, city, image, user, set columns to null
            $table->foreign('country_id')->references('id')->on('country')->onDelete('set null');
            $table->foreign('city_id')->references('id')->on('city')->onDelete('set null');
            $table->foreign('image_id')->references('id')->on('image')->onDelete('set null');
            $table->foreign('user_id')->references('id')->on('user')->onDelete('set null');
        });
        Schema::create('place_translation', function (Blueprint $table) {
            $table->integer('place_id')->unsigned();
            $table->string('language')->index();
            $table->boolean('complete');

            // Translated content
            $table->string('name');
            $table->text('content');

            $table->timestamps();

            // Unique and foreign key
            // When deleting city model, also delete all translation models
            $table->unique(['place_id','language']);
            $table->foreign('place_id')->references('id')->on('place')->onDelete('cascade');
        });
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
