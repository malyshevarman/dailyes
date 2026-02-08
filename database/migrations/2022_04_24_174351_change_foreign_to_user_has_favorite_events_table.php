<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeForeignToUserHasFavoriteEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_has_favorite_events', function (Blueprint $table) {
            $table->dropForeign('user_has_favorite_events_event_id_foreign');
            $table->foreign('event_id')->references('id')->on('events')
                ->onDelete('cascade');
            $table->dropForeign('user_has_favorite_events_user_id_foreign');
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
        Schema::table('user_has_favorite_events', function (Blueprint $table) {
            $table->dropForeign('user_has_favorite_events_event_id_foreign');
            $table->dropForeign('user_has_favorite_events_user_id_foreign');
            $table->foreign('event_id')->references('id')->on('events');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }
}
