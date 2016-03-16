<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticleImageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('article_image', function (Blueprint $table) {
            $table->integer('article_id')->unsigned();
            $table->integer('image_id')->unsigned();
            $table->integer('order')->unsigned();

            // Unique
            $table->unique(['article_id','image_id']);
            // Foreign key
            $table->foreign('article_id')->references('id')->on('article')->onDelete('cascade');
            $table->foreign('image_id')->references('id')->on('image')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('article_image');
    }
}
