<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UserHasFavoriteEvent extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_has_favorite_events', function (Blueprint $table) {
            $table->unsignedInteger('user_id');
            $table->unsignedBigInteger('event_id');
            $table->timestamps();
        });

        Schema::table('user_has_favorite_events', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('event_id')->references('id')->on('events');
            $table->unique(['user_id', 'event_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_has_favorite_events');
    }
}
