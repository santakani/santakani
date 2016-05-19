<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTaggableTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('taggable', function (Blueprint $table) {
            $table->integer('tag_id')->unsigned();
            $table->string('taggable_type');
            $table->integer('taggable_id')->unsigned();

            // Unique
            $table->unique(['tag_id', 'taggable_type', 'taggable_id']);

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
        Schema::drop('taggable');
    }
}
