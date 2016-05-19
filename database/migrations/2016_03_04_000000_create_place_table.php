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

            // Location
            $table->integer('country_id')->unsigned()->nullable();
            $table->integer('city_id')->unsigned()->nullable();
            // POINT `location` is added by raw SQL, since not supported by Laravel
            // `address` is in translation table

            // Cover image
            $table->integer('image_id')->unsigned()->nullable();

            // Owner
            $table->integer('user_id')->unsigned()->nullable();

            // Place type: shop, showroom, studio, school, etc.
            $table->string('type');

            // Contacts & links
            $table->string('email');
            $table->string('phone');
            $table->string('website');
            $table->string('facebook'); // Facebook page
            $table->string('google_plus'); // Google+ business page

            // Timestamps
            $table->timestamps();
            $table->softDeletes();

            // Foreign keys, when delete country, city, image, user, set columns to null
            $table->foreign('country_id')->references('id')->on('country')->onDelete('set null');
            $table->foreign('city_id')->references('id')->on('city')->onDelete('set null');
            $table->foreign('image_id')->references('id')->on('image')->onDelete('set null');
            $table->foreign('user_id')->references('id')->on('user')->onDelete('set null');
        });

        // MySQL/MariaDB POINT `location`
        DB::statement('ALTER TABLE place ADD location POINT AFTER city_id' );

        Schema::create('place_translation', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('place_id')->unsigned();
            $table->string('locale');

            // Translated content
            $table->string('name');
            $table->text('content');
            $table->string('address');

            $table->timestamps();

            // Unique and foreign key
            // When deleting city model, also delete all translation models
            $table->unique(['place_id','locale']);
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
