<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlaceImageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('place_image', function (Blueprint $table) {
            $table->integer('place_id')->unsigned();
            $table->integer('image_id')->unsigned();
            $table->integer('order')->unsigned();

            // Unique
            $table->unique(['place_id','image_id']);
            // Foreign key
            $table->foreign('place_id')->references('id')->on('place')->onDelete('cascade');
            $table->foreign('image_id')->references('id')->on('image')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('place_image');
    }
}
