<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUserIdForeignKey extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('place', function (Blueprint $table) {
            // When deleted image, set image_id to null
            $table->foreign('user_id')->references('id')->on('user')->onDelete('set null');
        });
        Schema::table('image', function (Blueprint $table) {
            // When deleted image, set image_id to null
            $table->foreign('user_id')->references('id')->on('user')->onDelete('set null');
        });
        Schema::table('designer', function (Blueprint $table) {
            // When deleted image, set image_id to null
            $table->foreign('user_id')->references('id')->on('user')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('place', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
        });
        Schema::table('image', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
        });
        Schema::table('designer', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
        });
    }
}
