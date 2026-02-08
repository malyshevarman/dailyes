<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_comments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('event_id');
            $table->unsignedInteger('user_id');
            $table->timestamp('date')->nullable();
            $table->text('text')->nullable();
            $table->smallInteger('star')->nullable();
            $table->boolean('rec')->nullable();
            $table->boolean('published')->default(0);
            $table->timestamps();
        });

        Schema::table('event_comments', function (Blueprint $table) {
            $table->foreign('event_id')->references('id')->on('events');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('event_comments');
    }
}
