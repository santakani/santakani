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

            $table->string('type'); // image, youtube, vimeo, soundcloud
            $table->string('format')->nullable(); // jpg, png, gif
            $table->integer('width')->unsigned()->nullable(); // Width of image and video
            $table->integer('height')->unsigned()->nullable(); // Height of image and video
            $table->string('external_url')->nullable(); // YouTube, Vimeo, SoundCloud, etc.
            $table->integer('user_id')->unsigned()->nullable(); // Who uploaded this image or video
            // Large size image: /public/storage/image/[id/1000]/[id%1000]/full.[format] max. 1200x1200px
            // Small size image: /public/storage/image/[id/1000]/[id%1000]/thumb.[format] max. 600x600px

            // Timestamps
            $table->timestamps();
            $table->softDeletes();

            // When deleted image, set image_id to null
            $table->foreign('user_id')->references('id')->on('user')->onDelete('set null');
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
