<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFiedsToTiles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tiles', function (Blueprint $table) {
            $table->unsignedBigInteger('city_id')->after('id');
        });
        Schema::table('tiles', function (Blueprint $table) {
            $table->foreign('city_id')->references('id')->on('cities');
        });

        Schema::table('slides', function (Blueprint $table) {
            $table->unsignedBigInteger('city_id')->after('id');
        });
        Schema::table('slides', function (Blueprint $table) {
            $table->foreign('city_id')->references('id')->on('cities');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tiles', function (Blueprint $table) {
            $table->dropColumn('city_id');
        });
        Schema::table('slides', function (Blueprint $table) {
            $table->dropColumn('city_id');
        });
    }
}
