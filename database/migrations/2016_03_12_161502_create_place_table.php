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
            $table->integer('city_id')->unsigned(); // ID of city
            $table->integer('image_id')->unsigned(); // ID of image
            $table->string('type'); // Shop, gallery, studio, etc.
            $table->string('address');
            $table->string('email');
            $table->string('phone');

            // Timestamps
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::create('place_translation', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('place_id')->unsigned();
            $table->string('locale')->index();

            // Translated content
            $table->string('name');
            $table->string('tagline');
            $table->text('guide');

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
