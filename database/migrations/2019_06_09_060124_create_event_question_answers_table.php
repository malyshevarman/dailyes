<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventQuestionAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_question_answers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->unsignedInteger('user_id');
            $table->unsignedBigInteger('question_id');
            $table->timestamp('date')->nullable();
            $table->text('text')->nullable();
            $table->boolean('published')->default(0);
            $table->timestamps();
        });

        Schema::table('event_question_answers', function (Blueprint $table) {
            $table->foreign('parent_id')->references('id')->on('event_question_answers');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('question_id')->references('id')->on('event_questions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('event_question_answers');
    }
}
