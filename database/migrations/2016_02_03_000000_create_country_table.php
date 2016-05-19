<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCountryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('country', function (Blueprint $table) {
            $table->increments('id');

            // Name in URL, lower-case. e.g. "finland", "germany"
            $table->string('slug')->unique();

            // Country code, ISO 3166-1 alpha-2, upper-case. e.g. "FI", "DE"
            $table->string('code')->unique();

            // Icon/cover image
            $table->integer('image_id')->unsigned()->nullable();

            // Timestamps
            $table->timestamps();
            $table->softDeletes();

            // Foreign key
            $table->foreign('image_id')->references('id')->on('image')->onDelete('set null');
        });

        Schema::create('country_translation', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('country_id')->unsigned();
            $table->string('locale');

            // Translated content
            $table->string('name');
            $table->text('content');

            // Timestamps
            $table->timestamps();

            // Unique
            $table->unique(['country_id','locale']);

            // Foreign key
            $table->foreign('country_id')->references('id')->on('country')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('country_translation');

        Schema::drop('country');
    }
}
