<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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

            // Location
            $table->integer('country_id')->unsigned()->nullable();
            $table->integer('city_id')->unsigned()->nullable();

            // Cover image
            $table->integer('image_id')->unsigned()->nullable();

            // Owner
            $table->integer('user_id')->unsigned()->nullable();

            // Links
            $table->string('email')->nullable();
            $table->string('website')->nullable();
            $table->string('facebook')->nullable();
            $table->string('twitter')->nullable();
            $table->string('google_plus')->nullable();
            $table->string('instagram')->nullable();

            // Timestamps
            $table->timestamps();
            $table->softDeletes();

            // Foreign keys
            $table->foreign('country_id')->references('id')->on('country')->onDelete('set null');
            $table->foreign('city_id')->references('id')->on('city')->onDelete('set null');
            $table->foreign('image_id')->references('id')->on('image')->onDelete('set null');
            $table->foreign('user_id')->references('id')->on('user')->onDelete('set null');
        });

        Schema::create('designer_translation', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('designer_id')->unsigned();
            $table->string('locale');

            // Translated content
            $table->string('name');
            $table->string('tagline');
            $table->text('content');

            $table->timestamps();

            // Unique
            $table->unique(['designer_id','locale']);

            // Foreign key
            $table->foreign('designer_id')->references('id')->on('designer')->onDelete('cascade');
        });
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
