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
 * CreateStoryTable
 *
 * Database migration to create "story" and "story_translation" table.
 *
 * @author Guo Yunhe <guoyunhebrave@gmail.com>
 * @see https://github.com/santakani/santakani.com/wiki/Story
 */
class CreateStoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('story', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('image_id')->unsigned()->nullable();

            $table->integer('user_id')->unsigned()->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('image_id')->references('id')->on('image')->onDelete('set null');
            $table->foreign('user_id')->references('id')->on('user')->onDelete('set null');
        });

        Schema::create('story_translation', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('story_id')->unsigned();
            $table->string('locale');

            $table->string('title')->nullable();
            $table->text('content')->nullable();

            $table->timestamps();

            $table->unique(['story_id','locale']);

            $table->foreign('story_id')->references('id')->on('story')->onDelete('cascade');
        });

        DB::statement('ALTER TABLE story_translation ADD FULLTEXT INDEX story_translation_title_ft_index(title)');
        DB::statement('ALTER TABLE story_translation ADD FULLTEXT INDEX story_translation_content_ft_index(content)');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('story_translation');

        Schema::drop('story');
    }
}
