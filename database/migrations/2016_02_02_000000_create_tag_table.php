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

            // Non-translated content
            $table->string('url_name')->unique(); // Name in URL

            // Timestamps
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::create('tag_translation', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('tag_id')->unsigned();
            $table->string('locale')->index();

            // Translated content
            $table->string('name');
            $table->string('alias')->nullable(); // For better search matches

            $table->timestamps();

            // Unique and foreign key
            // When deleting country model, also delete all translation models
            $table->unique(['tag_id','locale']);
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
