<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventRatingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_ratings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('event_id');
            $table->integer('one_star')->default(0);
            $table->integer('two_stars')->default(0);
            $table->integer('three_stars')->default(0);
            $table->integer('four_stars')->default(0);
            $table->integer('five_stars')->default(0);
            $table->timestamps();
        });

        Schema::table('event_ratings', function (Blueprint $table) {
            $table->foreign('event_id')->references('id')->on('events');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('event_ratings');
    }
}
