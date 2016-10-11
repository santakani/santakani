<?php

use App\Image;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class HardDeleteImages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Delete all trashed image files
        $images = Image::whereNotNull('deleted_at')->get();
        foreach ($images as $image) {
            $image->deleteDirectory();
        }

        // Delete trashed image records, a single SQL query is faster
        $images = Image::whereNotNull('deleted_at')->delete();

        // Remove deleted_at column
        Schema::table('image', function (Blueprint $table) {
            $table->dropColumn('deleted_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Add back soft delete timestamp
        Schema::table('image', function (Blueprint $table) {
            $table->softDeletes();
        });
    }
}
