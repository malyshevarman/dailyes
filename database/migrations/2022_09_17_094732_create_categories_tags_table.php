<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoriesTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories_tags', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->timestamps();
        });

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
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('category_has_categories_tags');
        Schema::dropIfExists('categories_tags');
    }
}
