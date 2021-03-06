<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOptionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('option', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('design_id')->unsigned();
            $table->string('type'); // color, size, material, custom
            $table->integer('image_id')->unsigned()->nullable();
            $table->decimal('price_add', 8, 2)->default(0);
            $table->string('value')->nullable();
            $table->boolean('available')->default(1);
            $table->integer('sort_order')->unsigned()->default(0)->index();
            $table->timestamps();

            $table->foreign('design_id')->references('id')->on('design')->onDelete('cascade');
            $table->foreign('image_id')->references('id')->on('image')->onDelete('set null');
        });

        Schema::create('option_translation', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('option_id')->unsigned();
            $table->string('locale');
            $table->string('name')->nullable();
            $table->timestamps();

            $table->unique(['option_id','locale']);

            $table->foreign('option_id')->references('id')->on('option')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('option_translation');
        Schema::dropIfExists('option');
    }
}
