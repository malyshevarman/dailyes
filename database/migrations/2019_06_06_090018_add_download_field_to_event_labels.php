<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDownloadFieldToEventLabels extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('event_labels', function (Blueprint $table) {
            $table->dropColumn('icon');
            $table->unsignedBigInteger('icon_download_id')->nullable();
        });

        Schema::table('event_labels', function (Blueprint $table) {
            $table->foreign('icon_download_id')->references('id')->on('downloads');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('event_labels', function (Blueprint $table) {
            $table->dropColumn('icon_download_id');
            $table->string('icon');
        });
    }
}
