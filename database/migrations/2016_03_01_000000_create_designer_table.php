<?php

/*
 * This file is part of santakani.com
 *
 * (c) Guo Yunhe <guoyunhebrave@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

/**
 * CreateDesignerTable
 *
 * Database migration to create "designer" and "designer_translation" table.
 *
 * @author Guo Yunhe <guoyunhebrave@gmail.com>
 * @see https://github.com/santakani/santakani.com/wiki/Designer
 */
class CreateDesignerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('designer', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('image_id')->unsigned()->nullable();
            $table->integer('logo_id')->unsigned()->nullable();

            $table->integer('city_id')->unsigned()->nullable();

            $table->string('email')->nullable();
            $table->string('website')->nullable();

            $table->string('facebook')->nullable();
            $table->string('twitter')->nullable();
            $table->string('google_plus')->nullable();
            $table->string('instagram')->nullable();

            $table->integer('user_id')->unsigned()->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('city_id')->references('id')->on('city')->onDelete('set null');
            $table->foreign('image_id')->references('id')->on('image')->onDelete('set null');
            $table->foreign('logo_id')->references('id')->on('image')->onDelete('set null');
            $table->foreign('user_id')->references('id')->on('user')->onDelete('set null');
        });

        Schema::create('designer_translation', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('designer_id')->unsigned();
            $table->string('locale'); // ISO 639-1 (2 letters)

            $table->string('name');
            $table->string('tagline');
            $table->text('content'); // HTML

            $table->timestamps();

            $table->unique(['designer_id','locale']);

            $table->foreign('designer_id')->references('id')->on('designer')->onDelete('cascade');
        });

        DB::statement('ALTER TABLE designer_translation ADD FULLTEXT INDEX designer_translation_name_ft_index(name)');
        DB::statement('ALTER TABLE designer_translation ADD FULLTEXT INDEX designer_translation_tagline_ft_index(tagline)');
        DB::statement('ALTER TABLE designer_translation ADD FULLTEXT INDEX designer_translation_content_ft_index(content)');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('designer_translation');

        Schema::drop('designer');
    }
}
