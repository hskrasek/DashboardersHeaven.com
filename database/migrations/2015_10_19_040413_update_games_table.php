<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class UpdateGamesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('games', function (Blueprint $table) {
            $table->text('description')->after('title')->nullable();
            $table->mediumText('short_description')->after('description')->nullable();
            $table->timestamp('release_date')->after('is_app')->nullable();
            $table->string('image_url')->nullable()->after('short_description');
            $table->mediumText('resize_image_url')->nullable()->after('image_url');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('games', function (Blueprint $table) {
            //
        });
    }
}
