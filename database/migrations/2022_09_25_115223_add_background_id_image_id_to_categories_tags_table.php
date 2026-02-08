<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBackgroundIdImageIdToCategoriesTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('categories_tags', function (Blueprint $table) {
            $table->unsignedBigInteger('background_download_id')->after('slug')->nullable();
            $table->unsignedBigInteger('image_download_id')->after('background_download_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('categories_tags', function (Blueprint $table) {
            $table->dropColumn('background_download_id');
            $table->dropColumn('image_download_id');
        });
    }
}
