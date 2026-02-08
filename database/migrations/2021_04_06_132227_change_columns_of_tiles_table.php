<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeColumnsOfTilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tiles', function (Blueprint $table) {
            $table->unsignedBigInteger('selection_id')->nullable()->change();
            $table->unsignedBigInteger('city_id')->nullable()->change();
            $table->unsignedBigInteger('category_id')->nullable()->after('id');
            $table->unsignedBigInteger('image_id')->nullable()->after('summary');
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
            // $table->unsignedBigInteger('selection_id')->nullable(false)->change();
            // $table->unsignedBigInteger('city_id')->nullable(false)->change();
            $table->dropColumn('category_id');
            $table->dropColumn('image_id');
        });
    }
}
