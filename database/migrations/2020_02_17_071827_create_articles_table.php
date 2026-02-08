<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('user_id');
            $table->string('title'); // Заголовок новости
            $table->string('slug'); // Ссылка на новость
            $table->text('description')->nullable();
            $table->text('text')->nullable();
            $table->unsignedBigInteger('preview_download_id')->nullable();
            $table->unsignedInteger('published')->default(0);
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::table('articles', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('preview_download_id')->references('id')->on('downloads');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('articles');
    }
}
