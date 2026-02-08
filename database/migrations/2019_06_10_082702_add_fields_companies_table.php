<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->text('about')->nullable();
            $table->double('star')->unsigned()->default('0');
            $table->unsignedInteger('rec')->default('0');
            $table->integer('views')->default('0');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->dropColumn('about');
            $table->dropColumn('star');
            $table->dropColumn('rec');
            $table->dropColumn('views');
        });
    }
}
