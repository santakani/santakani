<?php

/*
 * This file is part of santakani.com
 *
 * (c) Guo Yunhe <guoyunhebrave@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * CreateCountryTable
 *
 * Database migration to create "country" and "country_translation" table.
 *
 * @author Guo Yunhe <guoyunhebrave@gmail.com>
 * @see https://github.com/santakani/santakani.com/wiki/Country
 */
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

            $table->string('slug')->unique(); // e.g. "finland", "germany"
            $table->string('code')->unique(); // ISO 3166-1 alpha-2. e.g. "FI", "DE"
            $table->integer('image_id')->unsigned()->nullable();
            $table->string('region')->nullable(); // Continent, e.g. "Europe"
            $table->string('subregion')->nullable(); // e.g. "East Asia"
            $table->float('latitude', 10, 6)->nullable();
            $table->float('longitude', 10, 6)->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->index(['latitude', 'longitude']);

            $table->foreign('image_id')->references('id')->on('image')->onDelete('set null');
        });

        Schema::create('country_translation', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('country_id')->unsigned();
            $table->string('locale'); // Language code. ISO 639-1 (2 letters)

            $table->string('name')->nullable();
            $table->text('content')->nullable(); // HTML

            $table->timestamps();

            $table->unique(['country_id','locale']);

            $table->foreign('country_id')->references('id')->on('country')->onDelete('cascade');
        });

        DB::statement('ALTER TABLE country_translation ADD FULLTEXT INDEX country_translation_name_ft_index(name)');
        DB::statement('ALTER TABLE country_translation ADD FULLTEXT INDEX country_translation_content_ft_index(content)');
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
