<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddEditorRating extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        foreach (['design', 'designer', 'place', 'story'] as $table_name) {
            Schema::table($table_name, function (Blueprint $table) {
                $table->tinyInteger('editor_rating')->default(0)->after('like_count');
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
        foreach (['design', 'designer', 'place', 'story'] as $table_name) {
            Schema::table($table_name, function (Blueprint $table) {
                $table->dropColumn('editor_rating');
            });
        }
    }
}
