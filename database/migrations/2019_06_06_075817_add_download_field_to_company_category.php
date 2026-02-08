<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDownloadFieldToCompanyCategory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('company_categories', function (Blueprint $table) {
            $table->dropColumn('background');
            $table->unsignedBigInteger('background_download_id')->nullable();
        });

        Schema::table('company_categories', function (Blueprint $table) {
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
        Schema::table('company_categories', function (Blueprint $table) {
            $table->dropColumn('background_download_id');
            $table->string('background');
        });
    }
}
