<?php

use Illuminate\Database\Seeder;

class NotificationSettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	\App\NotificationSettings::truncate();

        \App\NotificationSettings::insert([
            [
                'name' => 'Отзывы',
                'type' => 'Comment',
            ],
            [
                'name' => 'Комментарии к отзывам',
                'type' => 'CommentAnswer',
            ],
            [
                'name' => 'Рассылка',
                'type' => 'Newsletter',
            ],
        ]);
    }
}
