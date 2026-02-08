<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UserHasFavoriteCompany extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_has_favorite_companies', function (Blueprint $table) {
            $table->unsignedInteger('user_id');
            $table->unsignedBigInteger('company_id');
            $table->timestamps();
        });

        Schema::table('user_has_favorite_companies', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('company_id')->references('id')->on('companies');
            $table->unique(['user_id', 'company_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_has_favorite_companies');
    }
}
