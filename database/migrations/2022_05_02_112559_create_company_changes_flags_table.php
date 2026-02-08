<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompanyChangesFlagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_changes_flags', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('company_id')->unique();
            $table->boolean('is_changed_name')->default(0);
            $table->boolean('is_changed_summary')->default(0);
            $table->boolean('is_changed_about')->default(0);
            $table->boolean('is_changed_categories')->default(0);
            $table->boolean('is_changed_slug')->default(0);
            $table->boolean('is_changed_image_download_id')->default(0);
            $table->boolean('is_changed_background_download_id')->default(0);
            $table->boolean('is_changed_gallery_items')->default(0);
            $table->boolean('is_changed_addresses')->default(0);
            $table->boolean('is_changed_user')->default(0);
            // $table->timestamps();
        });

        Schema::table('company_changes_flags', function (Blueprint $table) {
            $table->foreign('company_id')->references('id')->on('companies')
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
        Schema::dropIfExists('company_changes_flags');
    }
}
