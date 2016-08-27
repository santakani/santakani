<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDesignTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('design', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('designer_id')->unsigned()->nullable();
            $table->integer('user_id')->unsigned()->nullable();

            $table->integer('image_id')->unsigned()->nullable();

            $table->string('webshop')->nullable();
            $table->decimal('price', 5, 2)->unsigned()->nullable();
            $table->string('currency')->nullable();
            $table->decimal('eur_price', 5, 2)->unsigned()->nullable(); // for sort only

            $table->string('taobao')->nullable();
            $table->decimal('taobao_price', 5, 2)->unsigned()->nullable();

            $table->integer('like_count')->unsigned()->default(0);

            $table->timestamps();
            $table->softDeletes();

            $table->integer('locked_by')->unsigned()->nullable();
            $table->timestamp('locked_at')->nullable();

            $table->foreign('designer_id')->references('id')->on('designer')->onDelete('set null');
            $table->foreign('user_id')->references('id')->on('user')->onDelete('set null');
            $table->foreign('image_id')->references('id')->on('image')->onDelete('set null');
            $table->foreign('locked_by')->references('id')->on('user')->onDelete('set null');
        });

        Schema::create('design_translation', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('design_id')->unsigned();
            $table->string('locale');

            $table->string('name')->nullable();
            $table->text('content')->nullable();

            $table->timestamps();

            $table->unique(['design_id','locale']);

            $table->foreign('design_id')->references('id')->on('design')->onDelete('cascade');
        });

        DB::statement('ALTER TABLE design_translation ADD FULLTEXT INDEX design_translation_name_ft_index(name)');
        DB::statement('ALTER TABLE design_translation ADD FULLTEXT INDEX design_translation_content_ft_index(content)');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('design_translation');
        Schema::drop('design');
    }
}
