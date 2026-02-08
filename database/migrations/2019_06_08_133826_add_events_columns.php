<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddEventsColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('events', function (Blueprint $table) {
            $table->date('start');
            $table->date('end');
            $table->text('about')->nullable();
            $table->double('star')->unsigned()->default('0');
            $table->unsignedInteger('rec')->default('0');
            $table->integer('views')->default('0');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn('start');
            $table->dropColumn('end');
            $table->dropColumn('about');
            $table->dropColumn('star');
            $table->dropColumn('rec');
            $table->dropColumn('views');
        });
    }
}
