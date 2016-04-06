<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDesignerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('designer', function (Blueprint $table) {
            $table->increments('id');

            // Non-translated content
            $table->integer('country_id')->unsigned()->nullable(); // ID of country
            $table->integer('city_id')->unsigned()->nullable(); // ID of city
            $table->integer('image_id')->unsigned()->nullable(); // ID of image
            $table->integer('user_id')->unsigned()->nullable(); // Who own designer page

            // Timestamps
            $table->timestamps();
            $table->softDeletes();

            // Foreign keys, when delete country, city, image, user, set columns to null
            $table->foreign('country_id')->references('id')->on('country')->onDelete('set null');
            $table->foreign('city_id')->references('id')->on('city')->onDelete('set null');
            $table->foreign('image_id')->references('id')->on('image')->onDelete('set null');
            $table->foreign('user_id')->references('id')->on('user')->onDelete('set null');
        });
        Schema::create('designer_translation', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('designer_id')->unsigned();
            $table->string('language')->index();
            $table->boolean('complete');

            // Translated content
            $table->string('name');
            $table->text('content');

            $table->timestamps();

            // Unique and foreign key
            // When deleting designer model, also delete all translation models
            $table->unique(['designer_id','language']);
            $table->foreign('designer_id')->references('id')->on('designer')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('designer_translation');
        Schema::drop('designer');
    }
}
