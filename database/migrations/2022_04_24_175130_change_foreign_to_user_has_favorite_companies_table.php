<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeForeignToUserHasFavoriteCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_has_favorite_companies', function (Blueprint $table) {
            $table->dropForeign('user_has_favorite_companies_company_id_foreign');
            $table->foreign('company_id')->references('id')->on('companies')
                ->onDelete('cascade');
            $table->dropForeign('user_has_favorite_companies_user_id_foreign');
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
        Schema::table('user_has_favorite_companies', function (Blueprint $table) {
            $table->dropForeign('user_has_favorite_companies_company_id_foreign');
            $table->dropForeign('user_has_favorite_companies_user_id_foreign');
            $table->foreign('company_id')->references('id')->on('companies');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }
}
