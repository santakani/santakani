<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('image', function (Blueprint $table) {
            $table->increments('id');

            $table->string('type'); // Image, audio, video
            $table->string('format'); // jpg, png, gif
            $table->integer('width')->unsigned(); // Width of image and video
            $table->integer('height')->unsigned(); // Height of image and video
            $table->string('external_url'); // YouTube, Vimeo, SoundCloud, etc.
            $table->integer('user_id')->unsigned(); // Who uploaded this image or video
            // Large size image: /upload/image/[id]/large.[format] max. 1200x1200px
            // Small size image: /upload/image/[id]/small.[format] max. 600x600px

            // Timestamps
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('image');
    }
}
