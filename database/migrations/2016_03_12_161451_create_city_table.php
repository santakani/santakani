<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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

            // Non-translated content
            $table->string('url_name')->unique(); // Name in URL
            $table->integer('country_id')->unsigned(); // ID of country
            $table->integer('image_id')->unsigned()->nullable(); // ID of image

            // Timestamps
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::create('city_translation', function (Blueprint $table) {
            $table->integer('city_id')->unsigned();
            $table->string('locale')->index();
            $table->boolean('complete');

            // Translated content
            $table->string('name');
            $table->string('tagline');
            $table->text('guide');

            $table->timestamps();

            // Unique and foreign key
            // When deleting city model, also delete all translation models
            $table->unique(['city_id','locale']);
            $table->foreign('city_id')->references('id')->on('city')->onDelete('cascade');
        });
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
