<?php

use App\Subscriber;
use Illuminate\Database\Seeder;

class SubscriberTableSeederFaker extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Subscriber::class, 100)->create();
    }
}
