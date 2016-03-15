<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCityImageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('city_image', function (Blueprint $table) {
            $table->integer('city_id')->unsigned();
            $table->integer('image_id')->unsigned();
            $table->integer('order')->unsigned();

            // Unique
            $table->unique(['city_id','image_id']);
            // Foreign key
            $table->foreign('city_id')->references('id')->on('city')->onDelete('cascade');
            $table->foreign('image_id')->references('id')->on('media')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('city_image');
    }
}
