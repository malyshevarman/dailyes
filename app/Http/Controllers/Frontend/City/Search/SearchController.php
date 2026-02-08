<?php

namespace App\Http\Controllers\Frontend\City\Search;

use App\City;
use App\Company;
use App\Event;
use App\Http\Controllers\Controller;
use Artesaos\SEOTools\Facades\SEOTools;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $city = city();
        // TODO встроить фильтры
        $eventsQuery = Event::whereHas('addresses', function ($q) use ($city) {
                $q->where('city_id', $city->id);
            })->when($request->text, function ($q) use ($request) {
                $q->where('name', 'LIKE', '%' . $request->text . '%');
            })
            ->active();

        // if (!empty($request->text)) {
        //     $eventsQuery->where('name', 'LIKE', '%' . $request->text . '%');
        // }

        $eventsCount = (clone $eventsQuery)->count();

        $events = (clone $eventsQuery)->with([
            'addresses',
            'labels',
            'company',
            'company.category'
        ])
            ->orderBy('id', 'desc')
            ->limit(20)
            ->get();

        // TODO встроить фильтры
        $companiesQuery = Company::whereHas('addresses', function ($q) use ($city) {
                $q->where('city_id', $city->id);
            })->when($request->text, function ($q) use ($request) {
                $q->where('name', 'LIKE', '%' . $request->text . '%');
            })
            ->active();

        // if (!empty($request->text)) {
        //     $companiesQuery->where('name', 'LIKE', '%' . $request->text . '%');
        // }

        $companiesCount = (clone $companiesQuery)->count();

        $companies = (clone $companiesQuery)->with([
            'addresses',
            'category'
        ])
            ->orderBy('id', 'desc')
            ->limit(20)
            ->get();


        SEOTools::setTitle('Поиск в г.'.$city->name);
        SEOTools::setDescription('Поиск в г.'.$city->name);

        SEOTools::opengraph()->setUrl(url()->current());
        SEOTools::opengraph()->setType('website');
        SEOTools::opengraph()->setSiteName('Dailyes');
        SEOTools::opengraph()->addImage(env('APP_URL') . '/images/share_link_logo_banner.png');

        SEOTools::jsonLd()->setType('website');
        SEOTools::jsonLd()->setTitle('Поиск в г.'.$city->name);
        SEOTools::jsonLd()->setDescription('Поиск в г.'.$city->name);
        SEOTools::jsonLd()->setSite('Dailyes');
        SEOTools::jsonLd()->setUrl(url()->current());
        SEOTools::jsonLd()->addImage(env('APP_URL') . '/images/share_link_logo_banner.png');

        return view('frontend.city.search.index')
            // ->withCity($city)
            ->withEvents($events)
            ->withEventsCount($eventsCount)
            ->withCompanies($companies)
            ->withCompaniesCount($companiesCount);
    }
}
