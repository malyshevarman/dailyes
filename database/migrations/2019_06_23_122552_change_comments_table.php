<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('event_comment_answers');
        Schema::dropIfExists('company_comment_answers');

        Schema::dropIfExists('company_recomendations');

        Schema::dropIfExists('event_comments');
        Schema::dropIfExists('company_comments');

        Schema::create('comments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('user_id');
            $table->text('text');
            $table->unsignedBigInteger('commented_id');
            $table->string('commented_type');
            $table->boolean('published')->default(0);
            $table->timestamps();
        });

        Schema::table('comments', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users');
            $table->unique(['user_id', 'commented_id', 'commented_type'], 'unique_key');
        });

        Schema::create('comment_answers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->unsignedInteger('user_id');
            $table->unsignedBigInteger('comment_id');
            $table->text('text');
            $table->boolean('published')->default(0);
            $table->timestamps();
        });

        Schema::table('comment_answers', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
