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

            $table->string('mime_type'); // image/jpeg, image/png, image/gif
            $table->integer('width')->unsigned()->nullable(); // Original width
            $table->integer('height')->unsigned()->nullable(); // Original height

            $table->integer('user_id')->unsigned()->nullable();
            $table->string('parent_type')->nullable(); // Polymorphic relationship
            $table->integer('parent_id')->unsigned()->nullable();
            $table->integer('weight')->unsigned()->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->index(['parent_type', 'parent_id', 'weight']);

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
