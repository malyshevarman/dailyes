<?php

use App\Company;
use App\Event;
use App\EventCategory;
use Illuminate\Database\Seeder;

class EventTableFakerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $event_categories = EventCategory::select(['id'])->get();
        $company = Company::select(['id'])->get();

        factory(Event::class, 100)->create()->each(function (Event $event) use ($event_categories, $company) {
            $event_category = $event_categories->random();
            $company = $company->random();

            $event->event_categories()->save($event_category);
            $event->company()->associate($company);
            $event->save();
        });
    }
}
