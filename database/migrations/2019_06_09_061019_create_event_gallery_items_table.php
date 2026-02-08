<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventGalleryItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_gallery_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('event_id');
            $table->unsignedBigInteger('download_id')->nullable();
            $table->string('link')->nullable();
            $table->integer('sort')->nullable();
            $table->timestamps();
        });

        Schema::table('event_gallery_items', function (Blueprint $table) {
            $table->foreign('event_id')->references('id')->on('events');
            $table->foreign('download_id')->references('id')->on('downloads');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('event_gallery_items');
    }
}
