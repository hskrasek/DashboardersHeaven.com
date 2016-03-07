<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePhotoshopsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('photoshops', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('gamer_id')->unsigned();
            $table->string('title');
            $table->text('description');
            $table->json('media')->nullable();
            $table->string('uri')->nullable();
            $table->boolean('completed')->default(false);
            $table->timestamp('completed_at');
            $table->timestamps();

            $table->foreign('gamer_id')->references('id')->on('gamers')->onDelete('cascade');
            $table->index('completed');
            $table->index('completed_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('photoshops');
    }
}
