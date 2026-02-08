<?php

namespace App\Providers;

use App\City;
use App\Company;
use App\Event;
use App\GalleryItem;
use App\ReportsAnswer;
use App\Observers\CompanyObserver;
use App\Observers\EventObserver;
use App\Observers\GalleryItemObserver;
use App\Observers\ReportsAnswerObserver;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use App\Category;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);


        view()->composer('*', function ($view) {
            if (empty($view->city)) {
                $city = city();
            } else {
                $city = $view->city;
            }

            $view->with('city', $city);
        });


        Event::observe(EventObserver::class);
        Company::observe(CompanyObserver::class);
        GalleryItem::observe(GalleryItemObserver::class);
        ReportsAnswer::observe(ReportsAnswerObserver::class);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
