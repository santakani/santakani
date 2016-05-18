<?php

/*
 * This file is part of santakani.com
 *
 * (c) Guo Yunhe <guoyunhebrave@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * CreateImageTable
 *
 * Database migration to create "image" table. This table store metadata of
 * uploaded images. Current schema only supports images. In future it might
 * support audio and video if needed.
 *
 * @author Guo Yunhe <guoyunhebrave@gmail.com>
 * @see https://github.com/santakani/santakani.com/wiki/Image
 */

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

            // MIME type used to validate file content and decide file extension
            // Support image/jpeg, image/png, image/gif
            $table->string('mime_type');

            // Original width and height. Detect if it has large and medium sizes
            // generated.
            $table->integer('width')->unsigned()->nullable();
            $table->integer('height')->unsigned()->nullable();

            // Who uploaded this image. Users might want to reuse their images.
            $table->integer('user_id')->unsigned()->nullable();

            // Parent model type and id. Use Laravel Polymorphic relationships
            // "parent_type" can be "designer", "place", "country", "city"
            $table->string('parent_type')->nullable();
            $table->integer('parent_id')->unsigned()->nullable();

            // Timestamps
            $table->timestamps();

            // Foreign key
            // When deleted user, set user_id to null, but still keep the image.
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
