<?php

use App\EventCategory;
use Faker\Generator as Faker;

$factory->define(EventCategory::class, function (Faker $faker) {
    $number = rand(1, 2); // Количество слов в названии
    $words = $faker->unique()->words($number); // Генерируем слова
    $string = implode(' ', $words);  // Склееваем

    $string = ucfirst($string); // Первая буква большая

    return [
        'name' => $string
    ];
});
