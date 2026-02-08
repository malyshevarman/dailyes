<?php

use App\EventCategory;
use Illuminate\Database\Seeder;

class EventCategoryTableFakerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(EventCategory::class, 30)->create();
    }
}
