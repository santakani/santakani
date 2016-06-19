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
 * CreateTagTable
 *
 * Database migration to create "tag" and "tag_translation" table.
 *
 * @author Guo Yunhe <guoyunhebrave@gmail.com>
 * @see https://github.com/santakani/santakani.com/wiki/Tag
 */
class CreateTagTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tag', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('image_id')->unsigned()->nullable();
            $table->tinyInteger('level')->unsigned()->default(0);

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('image_id')->references('id')->on('image')->onDelete('set null');
        });

        Schema::create('tag_translation', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('tag_id')->unsigned();
            $table->string('locale'); // Language code. ISO 639-1 (2 letters)

            $table->string('name'); // e.g. "wood", "silver", "furniture"
            $table->string('alias'); // e.g. "cup,mug,glass"
            $table->string('description'); // Short plain text

            $table->timestamps();

            $table->unique(['tag_id','locale']);

            $table->foreign('tag_id')->references('id')->on('tag')->onDelete('cascade');
        });

        DB::statement('ALTER TABLE tag_translation ADD FULLTEXT INDEX tag_translation_name_ft_index(name)');
        DB::statement('ALTER TABLE tag_translation ADD FULLTEXT INDEX tag_translation_alias_ft_index(alias)');
        DB::statement('ALTER TABLE tag_translation ADD FULLTEXT INDEX tag_translation_description_ft_index(description)');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('tag_translation');

        Schema::drop('tag');
    }
}
