<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('article', function (Blueprint $table) {
            $table->increments('id');

            // Non-translated content
            $table->integer('image_id')->unsigned(); // ID of image
            $table->integer('user_id')->unsigned()->nullable(); // Who wrote this article

            // Timestamps
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::create('article_translation', function (Blueprint $table) {
            $table->integer('article_id')->unsigned();
            $table->string('locale')->index();

            // Translated content
            $table->string('name');
            $table->text('content');

            // Unique and foreign key
            // When deleting article model, also delete all translation models
            $table->unique(['article_id','locale']);
            $table->foreign('article_id')->references('id')->on('article')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('article_translation');
        Schema::drop('article');
    }
}
