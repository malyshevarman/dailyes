<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EventHasEventCategories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_has_event_categories', function (Blueprint $table) {
            $table->unsignedInteger('event_category_id'); // ИД категории компании
            $table->unsignedInteger('event_id'); // ИД компании
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('event_has_event_categories');
    }
}
