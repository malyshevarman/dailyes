<?php

use App\CompanyCategory;
use Illuminate\Database\Seeder;

class CompanyCategoryTableFakerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(CompanyCategory::class, 15)->create();
    }
}
