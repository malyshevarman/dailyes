<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRatingResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('event_ratings');
        Schema::dropIfExists('company_ratings');

        Schema::create('rating_results', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('estimated_id');
            $table->string('estimated_type');
            $table->unsignedInteger('star');
            $table->unsignedInteger('count');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rating_results');
    }
}
