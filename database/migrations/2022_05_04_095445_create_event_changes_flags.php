<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventChangesFlags extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_changes_flags', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('event_id')->unique();
            $table->boolean('is_changed_company_id')->default(0);
            $table->boolean('is_changed_name')->default(0);
            $table->boolean('is_changed_summary')->default(0);
            $table->boolean('is_changed_about')->default(0);
            $table->boolean('is_changed_categories')->default(0);
            $table->boolean('is_changed_slug')->default(0);
            $table->boolean('is_changed_image_download_id')->default(0);
            $table->boolean('is_changed_background_download_id')->default(0);
            $table->boolean('is_changed_gallery_items')->default(0);
            $table->boolean('is_changed_addresses')->default(0);
            $table->boolean('is_changed_user')->default(0);
        });

        Schema::table('event_changes_flags', function (Blueprint $table) {
            $table->foreign('event_id')->references('id')->on('events')
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
        Schema::dropIfExists('event_changes_flags');
    }
}
