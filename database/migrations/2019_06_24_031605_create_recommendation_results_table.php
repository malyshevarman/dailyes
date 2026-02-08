<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRecommendationResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('event_recommendations');

        Schema::create('recommendation_results', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('recommendable_id');
            $table->string('recommendable_type');
            $table->unsignedInteger('positive');
            $table->unsignedInteger('negative');
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
        Schema::dropIfExists('recommendation_results');
    }
}
