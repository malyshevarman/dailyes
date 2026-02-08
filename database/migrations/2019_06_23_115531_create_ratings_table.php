<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRatingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ratings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('user_id');
            $table->unsignedTinyInteger('star');
            $table->unsignedBigInteger('estimated_id');
            $table->string('estimated_type');
            $table->timestamps();
        });

        Schema::table('ratings', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users');
            $table->unique(['user_id', 'estimated_id', 'estimated_type']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ratings');
    }
}
