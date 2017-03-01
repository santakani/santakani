<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class StoryPublishedAtTimestamp extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('story', function (Blueprint $table) {
            $table->timestamp('published_at')->nullable()->after('updated_at');
        });

        DB::update('UPDATE story SET published_at = updated_at');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('story', function (Blueprint $table) {
            $table->dropColumn('published_at');
        });
    }
}
