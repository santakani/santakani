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
            $table->string('type')->nullable()->index();
            $table->timestamps();

            $table->foreign('design_id')->references('id')->on('design')->onDelete('cascade');
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
