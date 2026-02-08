<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveCompanyHasCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('company_has_categories');

        Schema::table('companies', function (Blueprint $table) {
            $table->unsignedBigInteger('category_id')->after('id');
            // $table->foreign('category_id', 'c_id_foreign')->references('id')->on('categories')->onDelete('cascade');
        });

        // Schema::table('company', function (Blueprint $table) {
            // $table->unsignedBigInteger('category_id')->after('id');
            // $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('company_has_categories', function (Blueprint $table) {
            $table->unsignedBigInteger('company_id');
            $table->unsignedBigInteger('category_id');
        });

        Schema::table('company_has_categories', function (Blueprint $table) {
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->unique(['category_id', 'company_id']);
        });

        Schema::table('companies', function (Blueprint $table) {
            // $table->dropForeign(['category_id']);
            $table->dropColumn('category_id');
        });
    }
}
