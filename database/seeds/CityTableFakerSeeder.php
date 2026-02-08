<?php

use Illuminate\Database\Seeder;

class CityTableFakerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\City::create([
            'name' => 'Москва',
            'slug' => 'moskva',
            'lat' => '55.753215',
            'long' => '37.622504',
            'timezone' => 'Europe/Moscow'
        ]);
    }
}
