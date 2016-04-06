<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDesignerImageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('designer_image', function (Blueprint $table) {
            $table->integer('designer_id')->unsigned();
            $table->integer('image_id')->unsigned();
            $table->integer('order')->unsigned();

            // Unique
            $table->unique(['designer_id','image_id']);
            // Foreign key
            $table->foreign('designer_id')->references('id')->on('designer')->onDelete('cascade');
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
        Schema::drop('designer_image');
    }
}
