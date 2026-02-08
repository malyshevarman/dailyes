<?php

namespace App\Http\Controllers\Frontend\City;

use App\BannerPlace;
use App\Event;
// use App\Category as Category;
use App\CategoriesTag;
use App\Http\Controllers\Controller;
use App\City;
use App\Slide;
use App\Tile;
use Artesaos\SEOTools\Facades\SEOTools;
use Illuminate\Http\Request;

class CityController extends Controller
{
    public function show(Request $request)
    {
        $city = city();
        $tags = CategoriesTag::whereHas('events', function ($q) use ($city) {
            $q->active()->whereHas('addresses', function ($q) use ($city) {
                $q->where('city_id', $city->id);
            });
        })->with('image')
        // ->orderBy('order', 'asc')
        ->get();

        $query = Event::whereHas('addresses', function ($q) use ($city) {
                $q->where('city_id', $city->id);
            })->with([
                'labels',
                'company.category',
                'company',
                'addresses',
                'image'
            ])->active();
            
        //Акции сегодня
        $eventsTodayQuery = (clone $query)->whereHas('labels', function($q) {
            $q->where('id', 1);
        });
        $eventsTodayCount = $eventsTodayQuery->count() >= 16 ? 16 : $eventsTodayQuery->count();
        $eventsToday = $eventsTodayQuery->orderBy('created_at', 'desc')->limit(16)->get();

        //Акции рекомендуем
        $eventsFavoriteQuery = (clone $query)->where('favorite', 1);
        $eventsFavoriteCount = $eventsFavoriteQuery->count() >= 16 ? 16 : $eventsFavoriteQuery->count();
        $eventsFavorite = $eventsFavoriteQuery->orderBy('id', 'desc')->get();

        //Акции лучшие оценки
        //TODO Учитывать количество голосов при равном рейтинге
        $eventsStarQuery = (clone $query)->where(
            function($q) {
                return $q
                    ->where('star','>=', '4');
            });
        $eventsStarCount = $eventsStarQuery->count() >= 16 ? 16 : $eventsStarQuery->count();
        $eventsStar = $eventsStarQuery->orderBy('star', 'desc')->get();


        //Акции популярные
        $eventsPopularQuery = (clone $query);
        $eventsPopularCount = $eventsPopularQuery->count() >= 16 ? 16 : $eventsPopularQuery->count();
        $eventsPopular = $eventsPopularQuery->orderBy('views', 'desc')->limit(10)->get();

        //Акции все акции портала
        $eventsAllQuery = (clone $query);
        $eventsAllCount = $eventsAllQuery->count();
        $eventsAll = $eventsAllQuery->orderBy('id', 'desc')->limit(10)->get();


        //Плитки на главной
        // Tile::active()->where('city_id', $city->id)->orWhere('city_id', null)->inRandomOrder()->get();
        $tiles = Tile::active()->where('city_id', $city->id)->orWhere('city_id', null)->inRandomOrder()->get();
        $tiles = $tiles->filter(function($model) use ($city){
                    if ($model->type == 'event-single') {
                        return isset($model->items);
                    } else {
                        if ($model->type == 'auto') {
                            $array = [];
                            foreach ($model->items as $key => $value) {
                                foreach ($value->addresses as $k => $address) {
                                    if ($address->city_id == $city->id) {
                                        $array[$value->id] = $value;
                                    }
                                }
                            }
                            // dd(array_values($array));
                            return count(array_values($array)) == 10;
                        } else {
                            return $model;
                        }
                    }
                });
            // dd($tiles);

        SEOTools::setTitle('Выгодные предложения, акции и скидки в г.'.$city->name);
        SEOTools::setDescription('На нашем сайте собраны лучшие скидки, акции, специальные предложения, бесплатные купоны и промокоды на каждый день, от разных компаний в г.'.$city->name.'! Регистрируйся и экономь вместе с Дейлис! ');

        SEOTools::opengraph()->setUrl(url()->current());
        SEOTools::opengraph()->setType('website');
        SEOTools::opengraph()->setSiteName('Dailyes');
        SEOTools::opengraph()->addImage(env('APP_URL') . '/images/share_link_logo_banner.png');

        SEOTools::jsonLd()->setType('website');
        SEOTools::jsonLd()->setTitle('Выгодные предложения, акции и скидки в г.'.$city->name);
        SEOTools::jsonLd()->setDescription('На нашем сайте собраны лучшие скидки, акции, специальные предложения, бесплатные купоны и промокоды на каждый день, от разных компаний в г.'.$city->name.'! Регистрируйся и экономь вместе с Дейлис! ');
        SEOTools::jsonLd()->setSite('Dailyes');
        SEOTools::jsonLd()->setUrl(url()->current());
        SEOTools::jsonLd()->addImage(env('APP_URL') . '/images/share_link_logo_banner.png');


        $addresses = (clone $query)->with(
                ['addresses.events' => function($q) {
                    $q->active();
                }, 'addresses.events.company:id,name', 'addresses.company:id,name'])->get()->reduce(function ($carry, $item) use ($city) {
                    $add = $item->addresses->filter(function ($item) use ($city) {
                        return $item->city_id == $city->id;
                    });
                    return $carry->merge($add);
                }, collect());

        return view('frontend.city.show')
            // ->withCity($city)
            ->withTags($tags)
            ->withEventsTodayCount($eventsTodayCount)
            ->withEventsToday($eventsToday)
            ->withEventsFavoriteCount($eventsFavoriteCount)
            ->withEventsFavorite($eventsFavorite)
            ->withEventsStarCount($eventsStarCount)
            ->withEventsStar($eventsStar)
            ->withEventsPopular($eventsPopular)
            ->withEventsPopularCount($eventsPopularCount)
            ->withEventsAllCount($eventsAllCount)
            ->withEventsAll($eventsAll)
            ->withAddresses($addresses)
            // ->withSlides(Slide::whereHas('city', function ($query) use ($city) {
            //     $query->where('id', $city->id);
            // })->orWhere('city_id', null)->where('selection_id', null)->with('selection.events', 'selection.companies')->inRandomOrder()->get())
            ->withSlides(Slide::inRandomOrder()->get())
            // ->withTiles(Tile::whereHas('city', function ($query) use ($city) {
            //     $query->where('id', $city->id);
            // })->with('selection.events', 'selection.companies')->inRandomOrder()->get())
            ->withTiles($tiles)
            ->withMainBannerPlace(BannerPlace::where('key', 'main-banner')->with([
                'activeBanners' => function ($query) use ($city) {
                    $query->whereHas('city', function ($query) use ($city) {
                        $query->where('id', $city->id);
                    })->inRandomOrder();
                },
                'activeBanners.download', 'activeBanners.mobile'
            ])->first());
    }
}
