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

            // Name in URL, lower-case. e.g. "finland", "germany"
            $table->string('slug')->unique();

            // Country id
            $table->integer('country_id')->unsigned()->nullable();

            // Icon/cover image
            $table->integer('image_id')->unsigned()->nullable();

            // Timestamps
            $table->timestamps();
            $table->softDeletes();

            // Foreign keys
            $table->foreign('country_id')->references('id')->on('country')->onDelete('set null');
            $table->foreign('image_id')->references('id')->on('image')->onDelete('set null');
        });

        Schema::create('city_translation', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('city_id')->unsigned();
            $table->string('locale');

            // Translated content
            $table->string('name');
            $table->text('content');

            // Timestamps
            $table->timestamps();

            // Unique
            $table->unique(['city_id','locale']);

            // Foreign key
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
