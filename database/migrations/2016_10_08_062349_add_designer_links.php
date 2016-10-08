<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDesignerLinks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('designer', function (Blueprint $table) {
            // Drop Google+ and Twitter
            $table->dropColumn('google_plus');
            $table->dropColumn('twitter');
            // Add Pinterest, YouTube and Vimeo
            $table->string('pinterest')->nullable()->after('instagram');
            $table->string('youtube')->nullable()->after('pinterest');
            $table->string('vimeo')->nullable()->after('youtube');
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
            // Recover Google+ and Twitter
            $table->string('twitter')->nullable()->after('facebook');
            $table->string('google_plus')->nullable()->after('facebook');
            // Remove Pinterest, YouTube and Vimeo
            $table->dropColumn('pinterest');
            $table->dropColumn('youtube');
            $table->dropColumn('vimeo');
        });
    }
}
