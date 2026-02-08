<?php

use Illuminate\Database\Seeder;

class BannerPlaceTableFakerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\BannerPlace::create([
            'name' => 'Баннер в списке акций - первый',
            'key' => 'event-list-one',
            'width' => 1200,
            'height' => 250
        ]);
        \App\BannerPlace::create([
            'name' => 'Баннер в списке акций - второй',
            'key' => 'event-list-second',
            'width' => 1200,
            'height' => 250
        ]);
        \App\BannerPlace::create([
            'name' => 'Баннер в списке акций - третий',
            'key' => 'event-list-tree',
            'width' => 1200,
            'height' => 250
        ]);
        \App\BannerPlace::create([
            'name' => 'Баннер в списке компаний - первый',
            'key' => 'company-list-one',
            'width' => 1200,
            'height' => 250
        ]);
        \App\BannerPlace::create([
            'name' => 'Баннер в списке компаний - второй',
            'key' => 'company-list-second',
            'width' => 1200,
            'height' => 250
        ]);
        \App\BannerPlace::create([
            'name' => 'Баннер в списке компаний - третий',
            'key' => 'company-list-tree',
            'width' => 1200,
            'height' => 250
        ]);
        \App\BannerPlace::create([
            'name' => 'Баннер в карточке акция - первый',
            'key' => 'event-one',
            'width' => 240,
            'height' => 400
        ]);
        \App\BannerPlace::create([
            'name' => 'Баннер в карточке акция - второй',
            'key' => 'event-second',
            'width' => 240,
            'height' => 400
        ]);
        \App\BannerPlace::create([
            'name' => 'Баннер в карточке компании - первый',
            'key' => 'company-one',
            'width' => 240,
            'height' => 400
        ]);
        \App\BannerPlace::create([
            'name' => 'Баннер в карточке компании - второй',
            'key' => 'company-second',
            'width' => 240,
            'height' => 400
        ]);
        \App\BannerPlace::create([
            'name' => 'Баннер на главной странице',
            'key' => 'main-banner',
            'width' => 1200,
            'height' => 250
        ]);
    }
}
