<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name'); // Название компании
            $table->string('slug'); // Ссылка на компанию
            $table->string('url')->nullable(); // Сайт компании
            $table->text('summary')->nullable(); // Описание компании
            $table->string('image')->nullable(); // Ссылка на изображение
            $table->string('background')->nullable(); // Ссылка на изображение
            $table->unsignedInteger('published')->default(0);  // Переключатель для админа для подтверждения
            $table->unsignedInteger('rejected')->default(0); // Отклонен или нет
            $table->text('message')->nullable(); // Если в модерации было отказано - то публикуем сообщение
            $table->unsignedInteger('active')->default(1); // Переключатель для пользователя для снятия с публикации
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
        Schema::dropIfExists('companies');
    }
}
