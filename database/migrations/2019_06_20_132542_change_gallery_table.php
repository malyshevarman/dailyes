<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeGalleryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('event_gallery_items');
        Schema::dropIfExists('company_gallery_items');

        Schema::create('event_gallery_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('event_id');
            $table->unsignedBigInteger('attachable_id');
            $table->string('attachable_type');
            $table->integer('sort')->nullable();
            $table->timestamps();
        });

        Schema::table('event_gallery_items', function (Blueprint $table) {
            $table->foreign('event_id')->references('id')->on('events');
        });

        Schema::create('company_gallery_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('company_id');
            $table->unsignedBigInteger('attachable_id');
            $table->string('attachable_type');
            $table->integer('sort')->nullable();
            $table->timestamps();
        });

        Schema::table('company_gallery_items', function (Blueprint $table) {
            $table->foreign('company_id')->references('id')->on('companies');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
