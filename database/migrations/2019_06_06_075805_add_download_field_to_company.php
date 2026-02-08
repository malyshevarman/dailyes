<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDownloadFieldToCompany extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->dropColumn('image');
            $table->unsignedBigInteger('image_download_id')->nullable();
            $table->dropColumn('background');
            $table->unsignedBigInteger('background_download_id')->nullable();
        });

        Schema::table('companies', function (Blueprint $table) {
            $table->foreign('image_download_id')->references('id')->on('downloads');
            $table->foreign('background_download_id')->references('id')->on('downloads');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->dropColumn('image_download_id');
            $table->string('image');
            $table->dropColumn('background_download_id');
            $table->string('background');
        });
    }
}
