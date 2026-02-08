<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRecommendationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recommendations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('user_id');
            $table->boolean('bool');
            $table->unsignedBigInteger('recommendable_id');
            $table->string('recommendable_type');
            $table->timestamps();
        });

        Schema::table('recommendations', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users');
            $table->unique(['user_id', 'recommendable_id', 'recommendable_type'], 'unique_key');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('recommendations');
    }
}
