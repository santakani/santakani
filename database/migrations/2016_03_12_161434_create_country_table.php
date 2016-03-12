<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCountryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('country', function (Blueprint $table) {
            $table->increments('id');

            // Non-translated content
            $table->integer('image')->unsigned(); // ID of image

            // Timestamps
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::create('country_translation', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('country_id')->unsigned();
            $table->string('locale')->index();

            // Translated content
            $table->string('name');
            $table->string('tagline');
            $table->text('guide');

            // Unique and foreign key
            // When deleting country model, also delete all translation models
            $table->unique(['country_id','locale']);
            $table->foreign('country_id')->references('id')->on('country')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('country');
        Schema::drop('country_translation');
    }
}
