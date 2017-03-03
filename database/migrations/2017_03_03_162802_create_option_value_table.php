<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOptionValueTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('option_value', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('option_id')->unsigned();
            $table->integer('image_id')->unsigned()->nullable();
            $table->decimal('price_add', 8, 2)->nullable();
            $table->string('value')->nullable();
            $table->timestamps();

            $table->foreign('option_id')->references('id')->on('option')->onDelete('cascade');
            $table->foreign('image_id')->references('id')->on('image')->onDelete('set null');
        });

        Schema::create('option_value_translation', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('option_value_id')->unsigned();
            $table->string('locale');
            $table->string('name')->nullable();
            $table->timestamps();

            $table->unique(['option_value_id','locale']);

            $table->foreign('option_value_id')->references('id')->on('option_value')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('option_value_translation');
        Schema::dropIfExists('option_value');
    }
}
