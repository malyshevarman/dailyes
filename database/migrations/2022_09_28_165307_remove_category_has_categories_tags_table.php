<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveCategoryHasCategoriesTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('category_has_categories_tags');

        Schema::table('categories_tags', function (Blueprint $table) {
            $table->unsignedBigInteger('category_id')->after('id');
            // $table->foreign('category_id', 'c_id_foreign')->references('id')->on('categories')->onDelete('cascade');
        });

        Schema::table('categories_tags', function (Blueprint $table) {
            // $table->unsignedBigInteger('category_id')->after('id');
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('category_has_categories_tags', function (Blueprint $table) {
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('categories_tag_id');
            // $table->timestamps();
        });

        Schema::table('category_has_categories_tags', function (Blueprint $table) {
            $table->foreign('category_id', 'c_id_foreign')->references('id')->on('categories')->onDelete('cascade');
            $table->foreign('categories_tag_id', 'ct_id_foreign')->references('id')->on('categories_tags')->onDelete('cascade');
            $table->unique(['category_id', 'categories_tag_id'], 'category_has_categories_tags_c_id_ct_id_unique');
        });

        Schema::table('categories_tags', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->dropColumn('category_id');
        });
    }
}
