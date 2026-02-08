<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeEventsCompaniesCategories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('event_has_event_categories');
        Schema::dropIfExists('company_has_company_categories');
        Schema::dropIfExists('event_categories');
        Schema::dropIfExists('company_categories');

        Schema::create('categories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('slug');
            $table->integer('order')->nullable(false)->default(999);
            $table->unsignedBigInteger('image_download_id')->nullable();
            $table->unsignedBigInteger('background_download_id')->nullable();
            $table->timestamps();
        });

        Schema::create('company_has_categories', function (Blueprint $table) {
            $table->unsignedBigInteger('company_id');
            $table->unsignedBigInteger('category_id');
        });

        Schema::table('company_has_categories', function (Blueprint $table) {
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->unique(['category_id', 'company_id']);
        });

        Schema::create('event_has_categories', function (Blueprint $table) {
            $table->unsignedBigInteger('event_id');
            $table->unsignedBigInteger('category_id');
        });

        Schema::table('event_has_categories', function (Blueprint $table) {
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->foreign('event_id')->references('id')->on('events')->onDelete('cascade');
            $table->unique(['category_id', 'event_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('company_has_categories');
        Schema::dropIfExists('event_has_categories');
        Schema::dropIfExists('categories');


        Schema::create('event_categories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('slug');
            $table->integer('order')->nullable(false)->default(999);
            $table->string('h1');
            $table->string('title', 255)->nullable();
            $table->text('description')->nullable();
            $table->text('text')->nullable();
            $table->unsignedBigInteger('image_download_id')->nullable();
            $table->unsignedBigInteger('background_download_id')->nullable();
            $table->timestamps();
        });

        Schema::create('company_categories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('slug');
            $table->string('h1');
            $table->string('title', 255)->nullable();
            $table->text('description')->nullable();
            $table->text('text')->nullable();
            $table->unsignedBigInteger('background_download_id')->nullable();
            $table->timestamps();
        });

        Schema::create('company_has_company_categories', function (Blueprint $table) {
            $table->unsignedInteger('company_category_id'); // ИД категории компании
            $table->unsignedInteger('company_id'); // ИД компании
        });

        Schema::create('event_has_event_categories', function (Blueprint $table) {
            $table->unsignedInteger('event_category_id'); // ИД категории компании
            $table->unsignedInteger('event_id'); // ИД компании
        });

    }
}
