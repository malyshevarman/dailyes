<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBackgroundDownloadIdColumnSelectionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('selections', function (Blueprint $table) {
            $table->bigInteger('background_downloads_id')->nullable()->after('params'); // Ссылка на изображение
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('selections', function (Blueprint $table) {
            $table->dropColumn('background_downloads_id');
        });
    }
}
