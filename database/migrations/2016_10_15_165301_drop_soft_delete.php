<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropSoftDelete extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        foreach (['city', 'country', 'tag', 'user'] as $table_name) {
            // Delete trashed records, a single SQL query is faster
            DB::table($table_name)->whereNotNull('deleted_at')->delete();
            // Remove deleted_at column
            Schema::table($table_name, function (Blueprint $table) {
                $table->dropColumn('deleted_at');
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
        // Add back soft delete timestamp
        foreach (['city', 'country', 'tag', 'user'] as $table_name) {
            Schema::table($table_name, function (Blueprint $table) {
                $table->softDeletes();
            });
        }
    }
}
