<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MergeFullTextIndex extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('story_translation', function (Blueprint $table) {
            $table->dropIndex('story_translation_title_ft_index');
            $table->dropIndex('story_translation_content_ft_index');
        });
        DB::statement('ALTER TABLE story_translation ADD FULLTEXT INDEX story_translation_title_content_ft_index(title,content)');

        Schema::table('designer_translation', function (Blueprint $table) {
            $table->dropIndex('designer_translation_name_ft_index');
            $table->dropIndex('designer_translation_tagline_ft_index');
            $table->dropIndex('designer_translation_content_ft_index');
        });
        DB::statement('ALTER TABLE designer_translation ADD FULLTEXT INDEX designer_translation_name_tagline_content_ft_index(name,tagline,content)');

        Schema::table('place_translation', function (Blueprint $table) {
            $table->dropIndex('place_translation_name_ft_index');
            $table->dropIndex('place_translation_content_ft_index');
        });
        DB::statement('ALTER TABLE place_translation ADD FULLTEXT INDEX place_translation_name_content_ft_index(name,content)');

        Schema::table('city_translation', function (Blueprint $table) {
            $table->dropIndex('city_translation_name_ft_index');
            $table->dropIndex('city_translation_content_ft_index');
        });
        DB::statement('ALTER TABLE city_translation ADD FULLTEXT INDEX city_translation_name_content_ft_index(name,content)');

        Schema::table('country_translation', function (Blueprint $table) {
            $table->dropIndex('country_translation_name_ft_index');
            $table->dropIndex('country_translation_content_ft_index');
        });
        DB::statement('ALTER TABLE country_translation ADD FULLTEXT INDEX country_translation_name_content_ft_index(name,content)');

        Schema::table('tag_translation', function (Blueprint $table) {
            $table->dropIndex('tag_translation_name_ft_index');
            $table->dropIndex('tag_translation_alias_ft_index');
            $table->dropIndex('tag_translation_description_ft_index');
        });
        DB::statement('ALTER TABLE tag_translation ADD FULLTEXT INDEX tag_translation_name_alias_description_ft_index(name,alias,description)');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('story_translation', function (Blueprint $table) {
            $table->dropIndex('story_translation_title_content_ft_index');
        });
        DB::statement('ALTER TABLE story_translation ADD FULLTEXT INDEX story_translation_title_ft_index(title)');
        DB::statement('ALTER TABLE story_translation ADD FULLTEXT INDEX story_translation_content_ft_index(content)');

        Schema::table('designer_translation', function (Blueprint $table) {
            $table->dropIndex('designer_translation_name_tagline_content_ft_index');
        });
        DB::statement('ALTER TABLE designer_translation ADD FULLTEXT INDEX designer_translation_name_ft_index(name)');
        DB::statement('ALTER TABLE designer_translation ADD FULLTEXT INDEX designer_translation_tagline_ft_index(tagline)');
        DB::statement('ALTER TABLE designer_translation ADD FULLTEXT INDEX designer_translation_content_ft_index(content)');

        Schema::table('place_translation', function (Blueprint $table) {
            $table->dropIndex('place_translation_name_content_ft_index');
        });
        DB::statement('ALTER TABLE place_translation ADD FULLTEXT INDEX place_translation_name_ft_index(name)');
        DB::statement('ALTER TABLE place_translation ADD FULLTEXT INDEX place_translation_content_ft_index(content)');

        Schema::table('city_translation', function (Blueprint $table) {
            $table->dropIndex('city_translation_name_content_ft_index');
        });
        DB::statement('ALTER TABLE city_translation ADD FULLTEXT INDEX city_translation_name_ft_index(name)');
        DB::statement('ALTER TABLE city_translation ADD FULLTEXT INDEX city_translation_content_ft_index(content)');

        Schema::table('country_translation', function (Blueprint $table) {
            $table->dropIndex('country_translation_name_content_ft_index');
        });
        DB::statement('ALTER TABLE country_translation ADD FULLTEXT INDEX country_translation_name_ft_index(name)');
        DB::statement('ALTER TABLE country_translation ADD FULLTEXT INDEX country_translation_content_ft_index(content)');

        Schema::table('tag_translation', function (Blueprint $table) {
            $table->dropIndex('tag_translation_name_alias_description_ft_index');
        });
        DB::statement('ALTER TABLE tag_translation ADD FULLTEXT INDEX tag_translation_name_ft_index(name)');
        DB::statement('ALTER TABLE tag_translation ADD FULLTEXT INDEX tag_translation_alias_ft_index(alias)');
        DB::statement('ALTER TABLE tag_translation ADD FULLTEXT INDEX tag_translation_description_ft_index(description)');
    }
}
