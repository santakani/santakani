<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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

            // Name in URL, lowercase, e.g. "chair", "solid-wood"
            $table->string('slug')->unique();

            // Icon/cover image
            $table->integer('image_id')->unsigned()->nullable();

            // Timestamps
            $table->timestamps();
            $table->softDeletes();

            // Foreign key
            $table->foreign('image_id')->references('id')->on('image')->onDelete('set null');
        });

        Schema::create('tag_translation', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('tag_id')->unsigned();
            $table->string('locale');

            // Translated content
            $table->string('name');
            $table->string('alias')->nullable(); // For better search matches

            $table->timestamps();

            // Unique
            $table->unique(['tag_id','locale']);
            // Foreign key
            $table->foreign('tag_id')->references('id')->on('tag')->onDelete('cascade');
        });
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
