<?php

use App\Event;
use Faker\Generator as Faker;

$factory->define(Event::class, function (Faker $faker) {
    $number = rand(1, 5); // Количество слов в названии
    $words = $faker->words($number); // Генерируем слова
    $string = implode(' ', $words);  // Склееваем

    $string = ucfirst($string); // Первая буква большая
    $rejected = rand(0, 1);

    return [
        'name' => $string,
        'summary' => $faker->optional()->sentence,
        'published' => rand(0, 1),
        'rejected' => $rejected,
        'message' => $rejected ? $faker->optional()->sentence : null,
        'active' => rand(0, 1)
    ];
});
