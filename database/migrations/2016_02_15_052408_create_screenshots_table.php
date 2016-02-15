<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateScreenshotsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('screenshots', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('gamer_id')->unsigned();
            $table->char('screenshot_id', 36);
            $table->bigInteger('title_id')->unsigned();
            $table->integer('width')->unsigned();
            $table->integer('height')->unsigned();
            $table->string('thumbnail_small', 2000)->nullable();
            $table->string('thumbnail_large', 2000)->nullable();
            $table->string('url', 2000)->nullable();

            $table->boolean('saved')->default(false);
            $table->boolean('expired')->default(false);
            $table->timestamp('expires_at');
            $table->timestamp('taken_at');
            $table->timestamps();

            $table->index('screenshot_id');
            $table->index('title_id');
            $table->index('gamer_id');
            $table->index('expired');
            $table->index('expires_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('screenshots');
    }
}
