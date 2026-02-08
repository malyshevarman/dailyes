<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToCommentAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('comment_answers', function (Blueprint $table) {
            $table->boolean('rejected')->default(false)->after('published');
            $table->boolean('is_moderated')->default(false)->after('rejected');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('comment_answers', function (Blueprint $table) {
            $table->dropColumn('rejected');
            $table->dropColumn('is_moderated');
        });
    }
}
