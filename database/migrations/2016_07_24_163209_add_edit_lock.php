<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddEditLock extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        foreach (['designer', 'place', 'story', 'tag', 'country', 'city'] as $table_name) {
            Schema::table($table_name, function (Blueprint $table) {
                $table->integer('locked_by')->unsigned()->nullable();
                $table->timestamp('locked_at')->nullable();

                $table->foreign('locked_by')->references('id')->on('user')->onDelete('set null');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        foreach (['designer', 'place', 'story', 'tag', 'country', 'city'] as $table_name) {
            Schema::table($table_name, function (Blueprint $table) use ($table_name) {
                $table->dropForeign($table_name.'_locked_by_foreign');
                $table->dropColumn('locked_by');
                $table->dropColumn('locked_at');
            });
        }
    }
}
