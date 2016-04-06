<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDesignerTagTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('designer_tag', function (Blueprint $table) {
            $table->integer('designer_id')->unsigned();
            $table->integer('tag_id')->unsigned();

            // Unique
            $table->unique(['designer_id','tag_id']);
            // Foreign key
            $table->foreign('designer_id')->references('id')->on('designer')->onDelete('cascade');
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
        Schema::drop('designer_tag');
    }
}
