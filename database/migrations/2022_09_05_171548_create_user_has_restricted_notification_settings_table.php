<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserHasRestrictedNotificationSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_has_restricted_notification_settings', function (Blueprint $table) {
            $table->unsignedInteger('user_id');
            $table->unsignedBigInteger('notification_settings_id');
            $table->timestamps();
        });

        Schema::table('user_has_restricted_notification_settings', function (Blueprint $table) {
            $table->foreign('user_id', 'u_id_foreign')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('notification_settings_id', 'ns_id_foreign')->references('id')->on('notification_settings')->onDelete('cascade');
            $table->unique(['user_id', 'notification_settings_id'], 'user_has_restricted_notification_settings_u_id_ns_id_unique');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_has_restricted_notification_settings');
    }
}
