<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('city', function (Blueprint $table) {
            $table->increments('id');

            // Name in URL, lower-case. e.g. "helsinki", "beijing"
            $table->string('slug', 50);

            // Country id
            $table->integer('country_id')->unsigned()->nullable();

            // Icon/cover image
            $table->integer('image_id')->unsigned()->nullable();

            // Timezone, like "Europe/Helsinki", "Asia/Shanghai"
            $table->string('timezone', 30);

            // Timestamps
            $table->timestamps();
            $table->softDeletes();

            // Unique
            $table->unique(['country_id', 'slug']);

            // Foreign keys
            $table->foreign('country_id')->references('id')->on('country')->onDelete('set null');
            $table->foreign('image_id')->references('id')->on('image')->onDelete('set null');
        });

        // MySQL/MariaDB GEOMETRY, which is not supported by Laravel Blueprint
        DB::statement('ALTER TABLE city ADD coordinate POINT AFTER image_id');

        Schema::create('city_translation', function (Blueprint $table) {
            $table->increments('id');

            // Parent
            $table->integer('city_id')->unsigned();

            // ISO 639-1 codes (2 letters)
            $table->string('locale', 2);

            // Name
            $table->string('name')->nullable();

            // Page content
            $table->text('content')->nullable();

            // Timestamps
            $table->timestamps();

            // Unique
            $table->unique(['city_id','locale']);

            // Foreign key
            $table->foreign('city_id')->references('id')->on('city')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('city_translation');

        Schema::drop('city');
    }
}
