<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('company_id'); // Компания - владелец акции
            $table->string('name'); // Название акции
            $table->string('slug'); // Ссылка на акцию
            $table->text('summary')->nullable(); // Описание компании
            $table->string('image')->nullable(); // Ссылка на изображение
            $table->string('background')->nullable(); // Ссылка на изображение
            $table->unsignedInteger('published')->default(0); // Переключатель для админа для подтверждения публикации
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
        Schema::dropIfExists('events');
    }
}
