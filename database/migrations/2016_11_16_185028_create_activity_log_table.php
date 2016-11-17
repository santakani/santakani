<?php

/*
 * This file is part of Santakani
 *
 * (c) Guo Yunhe <guoyunhebrave@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Create table for system activity log
 *
 * @see https://github.com/santakani/santakani/wiki/Activity-Log
 */
class CreateActivityLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activity_log', function (Blueprint $table) {
            $table->increments('id');

            $table->string('action')->nullable()->index();
            $table->text('message')->nullable();
            $table->text('metadata')->nullable();

            $table->tinyInteger('level')->unsigned()->default(0);

            $table->string('target_type')->nullable();
            $table->integer('target_id')->unsigned()->nullable();

            $table->integer('user_id')->unsigned()->nullable();

            $table->timestamps();

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
        Schema::drop('activity_log');
    }
}
