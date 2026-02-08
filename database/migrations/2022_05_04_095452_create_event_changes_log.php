<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventChangesLog extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_changes_log', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('event_id');
            $table->unsignedInteger('user_id')->nullable();
            $table->json('original_data')->nullable();
            $table->json('changed_data')->nullable();
            $table->string('route')->nullable();
            $table->timestamps();
        });

        Schema::table('event_changes_log', function (Blueprint $table) {
            $table->foreign('event_id')->references('id')->on('events')
                ->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('event_changes_log');
    }
}
