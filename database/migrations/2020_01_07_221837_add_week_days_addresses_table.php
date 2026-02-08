<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddWeekDaysAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('addresses', function (Blueprint $table) {
            $table->string('mon')->nullable()->after('work');
            $table->string('tues')->nullable()->after('mon');
            $table->string('wed')->nullable()->after('tues');
            $table->string('thurs')->nullable()->after('wed');
            $table->string('fri')->nullable()->after('thurs');
            $table->string('sat')->nullable()->after('fri');
            $table->string('sun')->nullable()->after('sat');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('addresses', function (Blueprint $table) {
            $table->dropColumn('mon');
            $table->dropColumn('tues');
            $table->dropColumn('wed');
            $table->dropColumn('thurs');
            $table->dropColumn('fri');
            $table->dropColumn('sat');
            $table->dropColumn('sun');
        });
    }
}
