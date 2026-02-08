<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBannerTableMobileDownloadId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('banners', function (Blueprint $table) {
            $table->unsignedBigInteger('mobile_download_id')->after('download_id')->nullable();
        });

        Schema::table('banners', function (Blueprint $table) {
            $table->foreign('mobile_download_id')->references('id')->on('downloads');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('banners', function (Blueprint $table) {
            $table->dropForeign(['mobile_download_id']);
            $table->dropColumn('mobile_download_id');
        });
    }
}
