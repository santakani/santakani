<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddEditorPick extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('designer', function (Blueprint $table) {
            $table->boolean('editor_pick')->default(false)->after('user_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('designer', function (Blueprint $table) {
            $table->dropColumn('editor_pick');
        });
    }
}
