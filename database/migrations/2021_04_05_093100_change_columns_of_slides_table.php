<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeColumnsOfSlidesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('slides', function (Blueprint $table) {
            $table->unsignedBigInteger('selection_id')->nullable()->change();
            $table->unsignedBigInteger('city_id')->nullable()->change();
            $table->unsignedBigInteger('category_id')->nullable()->after('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('slides', function (Blueprint $table) {
            // $table->unsignedBigInteger('selection_id')->nullable(false)->change();
            // $table->unsignedBigInteger('city_id')->nullable(false)->change();
            $table->dropColumn('category_id');
        });
    }
}
