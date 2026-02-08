<?php

use App\Company;
use Faker\Generator as Faker;

$factory->define(Company::class, function (Faker $faker) {
    $number = rand(1, 5); // Количество слов в названии
    $words = $faker->words($number); // Генерируем слова
    $string = implode(' ', $words);  // Склееваем

    $string = ucfirst($string); // Первая буква большая
    $rejected = rand(0, 1);

    $protocols = ['http', 'https'];
    $zones = ['ru', 'com', 'info', 'org', 'page', 'aero', 'su'];
    $url = $protocols[array_rand($protocols, 1)] . '//' . $faker->word . '.' . $zones[array_rand($zones, 1)] . '/';
    return [
        'name' => $string,
        'url' => rand(0, 1) ? $url : null,
        'summary' => $faker->optional()->sentence,
        'published' => rand(0, 1),
        'rejected' => $rejected,
        'message' => $rejected ? $faker->optional()->sentence : null,
        'active' => rand(0, 1)
    ];
});
