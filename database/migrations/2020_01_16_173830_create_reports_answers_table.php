<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReportsAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reports_answers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->unsignedInteger('user_id');
            $table->unsignedBigInteger('report_id');
            $table->text('text')->nullable();
            $table->boolean('published')->default(0);
            $table->timestamps();
        });

        Schema::table('reports_answers', function (Blueprint $table) {
            $table->foreign('parent_id')->references('id')->on('reports_answers');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('report_id')->references('id')->on('reports')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reports_answers');
    }
}
