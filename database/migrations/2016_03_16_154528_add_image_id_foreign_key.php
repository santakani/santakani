<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddImageIdForeignKey extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('country', function (Blueprint $table) {
            // When deleted image, set image_id to null
            $table->foreign('image_id')->references('id')->on('image')->onDelete('set null');
        });
        Schema::table('city', function (Blueprint $table) {
            // When deleted image, set image_id to null
            $table->foreign('image_id')->references('id')->on('image')->onDelete('set null');
        });
        Schema::table('place', function (Blueprint $table) {
            // When deleted image, set image_id to null
            $table->foreign('image_id')->references('id')->on('image')->onDelete('set null');
        });
        Schema::table('tag', function (Blueprint $table) {
            // When deleted image, set image_id to null
            $table->foreign('image_id')->references('id')->on('image')->onDelete('set null');
        });
        Schema::table('article', function (Blueprint $table) {
            // When deleted image, set image_id to null
            $table->foreign('image_id')->references('id')->on('image')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('country', function (Blueprint $table) {
            $table->dropForeign(['image_id']);
        });
        Schema::table('city', function (Blueprint $table) {
            $table->dropForeign(['image_id']);
        });
        Schema::table('place', function (Blueprint $table) {
            $table->dropForeign(['image_id']);
        });
        Schema::table('tag', function (Blueprint $table) {
            $table->dropForeign(['image_id']);
        });
        Schema::table('article', function (Blueprint $table) {
            $table->dropForeign(['image_id']);
        });
    }
}
