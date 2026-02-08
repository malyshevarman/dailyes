<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CompanyHasCompanyCategories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_has_company_categories', function (Blueprint $table) {
            $table->unsignedInteger('company_category_id'); // ИД категории компании
            $table->unsignedInteger('company_id'); // ИД компании
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('company_has_company_categories');
    }
}
