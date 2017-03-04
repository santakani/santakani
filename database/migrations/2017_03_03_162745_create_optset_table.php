<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOptsetTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('optset', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('design_id')->unsigned();
            $table->string('type')->nullable()->index();
            $table->timestamps();

            $table->foreign('design_id')->references('id')->on('design')->onDelete('cascade');
        });

        Schema::create('optset_translation', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('optset_id')->unsigned();
            $table->string('locale');
            $table->string('name')->nullable();
            $table->timestamps();

            $table->unique(['optset_id','locale']);

            $table->foreign('optset_id')->references('id')->on('optset')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('optset_translation');
        Schema::dropIfExists('optset');
    }
}
