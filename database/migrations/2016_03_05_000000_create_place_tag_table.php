<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlaceTagTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('place_tag', function (Blueprint $table) {
            $table->integer('place_id')->unsigned();
            $table->integer('tag_id')->unsigned();

            // Unique
            $table->unique(['place_id','tag_id']);
            // Foreign key
            $table->foreign('place_id')->references('id')->on('place')->onDelete('cascade');
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
        Schema::drop('place_tag');
    }
}
