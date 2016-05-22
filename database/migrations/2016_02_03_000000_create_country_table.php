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
            $table->string('slug', 50)->unique();

            // Country code, ISO 3166-1 alpha-2, upper-case. e.g. "FI", "DE"
            $table->string('code', 2)->unique();

            // Icon/cover image
            $table->integer('image_id')->unsigned()->nullable();

            // Region/continent
            $table->string('region', 10)->nullable();

            // Subregion
            $table->string('subregion', 20)->nullable();

            // Timestamps
            $table->timestamps();
            $table->softDeletes();

            // Foreign key
            $table->foreign('image_id')->references('id')->on('image')->onDelete('set null');
        });

        // MySQL/MariaDB GEOMETRY, which is not supported by Laravel Blueprint
        DB::statement('ALTER TABLE country ADD coordinate POINT AFTER subregion');
        DB::statement('ALTER TABLE country ADD border MULTIPOLYGON AFTER coordinate');

        Schema::create('country_translation', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('country_id')->unsigned();
            // ISO 639-1 codes (2 letters)
            $table->string('locale', 2);

            // Flags
            $table->boolean('native');

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
