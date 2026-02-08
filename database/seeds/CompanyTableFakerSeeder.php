<?php

use App\Company;
use App\CompanyCategory;
use Illuminate\Database\Seeder;

class CompanyTableFakerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $company_categories = CompanyCategory::select(['id'])->get();

        factory(Company::class, 100)->create()->each(function (Company $company) use ($company_categories) {
            $company_category = $company_categories->random();

            $company->company_categories()->save($company_category);
        });
    }
}
