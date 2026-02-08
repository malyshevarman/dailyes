<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tiles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->text('summary');
            $table->unsignedBigInteger('selection_id');
            $table->timestamps();
        });

        Schema::table('tiles', function (Blueprint $table) {
            $table->foreign('selection_id')->references('id')->on('selections');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tiles');
    }
}
