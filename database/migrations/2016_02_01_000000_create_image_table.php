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

            $table->string('mime_type'); // image/jpg, video/youtube
            $table->integer('width')->unsigned()->nullable();
            $table->integer('height')->unsigned()->nullable();
            $table->string('external_url')->nullable(); // YouTube, Vimeo URL
            $table->integer('user_id')->unsigned()->nullable(); // Who uploaded this image or video

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
