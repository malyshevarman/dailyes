<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RolesTableSeeder::class);

        $this->call(UsersTableSeeder::class);

        $this->call(ProfileTableSeeder::class);

        $this->call(DashboardTableSeeder::class);

//        $this->call(CityTableSeeder::class);
        $this->call(CityTableFakerSeeder::class);
//
//        $this->call(CompanyCategoryTableFakerSeeder::class);
//        $this->call(CompanyCategoryTableSeeder::class);
//
//        $this->call(CompanyTableSeeder::class);
//        $this->call(CompanyTableFakerSeeder::class);
//
//        $this->call(EventCategoryTableSeeder::class);
//        $this->call(EventCategoryTableFakerSeeder::class);
//
//        $this->call(EventTableSeeder::class);
//        $this->call(EventTableFakerSeeder::class);
//
//        $this->call(PageTableSeeder::class);
        $this->call(PageTableSeederFaker::class);
//
//        $this->call(SubscriberTableSeeder::class);
//        $this->call(SubscriberTableSeederFaker::class);
//
//        $this->call(EventLabelTableSeeder::class);

        $this->call(BannerPlaceTableFakerSeeder::class);

        // $this->call(NotificationSettingsTableSeeder::class);
    }
}
