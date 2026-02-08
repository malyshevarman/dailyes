<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSlidesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('slides', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->text('summary');
            $table->string('button');
            $table->unsignedBigInteger('image_id');
            $table->unsignedBigInteger('selection_id');
            $table->timestamps();
        });

        Schema::table('slides', function (Blueprint $table) {
            $table->foreign('image_id')->references('id')->on('downloads');
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
        Schema::dropIfExists('slides');
    }
}
