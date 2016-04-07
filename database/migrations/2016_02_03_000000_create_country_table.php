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
            $table->string('url_name')->unique(); // Name in URL
            $table->integer('image_id')->unsigned()->nullable(); // ID of image
            $table->string('country_code')->unique(); // Name in URL

            // Timestamps
            $table->timestamps();
            $table->softDeletes();

            // When deleted image, set image_id to null
            $table->foreign('image_id')->references('id')->on('image')->onDelete('set null');
        });
        Schema::create('country_translation', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('country_id')->unsigned();
            $table->string('language')->index();
            $table->boolean('complete');

            // Translated content
            $table->string('name');
            $table->text('content');

            $table->timestamps();

            // Unique and foreign key
            // When deleting country model, also delete all translation models
            $table->unique(['country_id','language']);
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
        Schema::drop('country_translation');
        Schema::drop('country');
    }
}
