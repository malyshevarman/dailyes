<?php

namespace App\Http\Controllers\Frontend\City\Event\Tag;

use App\CategoriesTag;
use App\BannerPlace;
use App\City;
use App\Event;
use App\Address;
use App\Category as Category;
use App\Http\Controllers\Controller;
use Artesaos\SEOTools\Facades\SEOTools;
use Illuminate\Http\Request;
use Storage;


class TagController extends Controller
{
    public function show(Request $request, CategoriesTag $tag)
    {
        if (!is_null($request->input('page')) && !is_numeric($request->input('page'))) {
            return redirect($request->url());
        }
        //Строка для вывода параметров фильтра на фронт
        // $requestInput = [];
        // $location = null;
        // $categoryIds = [];
        $city = city();
        // $startDate = null;
        // $endDate = null;
        // $dates = $request->input('date') ? explode('_', $request->input('date')) : null;
        // if (!empty($dates)) {
        //     $startDate = $dates[0];
        //     $endDate = $dates[1];
        //     $requestInput['По дате:'] = 'c ' . $startDate . ' по ' . $endDate;
        // }

        // if ($request->input('tags') && is_array($request->input('tags'))) {
        //     $categoryIds = $request->input('tags');
        //     $categories_names = Category::whereIn('id', $categoryIds)->get(['id', 'name'])->toArray();
        //     $requestInput['Категории:'] = $categories_names;
        // }

        // if (!is_null($request->input('location.name')) || !is_null($request->input('location.coords'))) {
        //     $api = new \Yandex\Geo\Api();
        //                     $api->setToken('f679a5dd-9081-411e-abf2-ac4a32c74e0c');
        //                     if (!empty($request->input('location.name'))) {
        //                         $api->setQuery($request->input('location.name'));
        //                     }
        //                     if (!empty($request->input('location.coords'))) {
        //                         $coords = explode(',', $request->input('location.coords'));
        //                         $api->setPoint($coords[1], $coords[0]);
        //                     }
        //                     $api->setLimit(1)// кол-во результатов
        //                     ->setLang(\Yandex\Geo\Api::LANG_RU)// локаль ответа
        //                     ->load();
        //                     $response = $api->getResponse();

        //                     $location = new \stdClass();
        //                     $location->lat = $response->getList()[0]->getLatitude();
        //                     $location->lng = $response->getList()[0]->getLongitude();
        //     $requestInput['Адрес:'] = $request->input('location.name');
        // }


        $query = Event::when($tag, function ($q) use ($tag) {
                            $q->whereHas('tags', function ($q) use ($tag) {
                                $q->where('id', $tag->id);
                            });
                        })
                        // ->when($request->input('tags') && is_array($request->input('tags')), function ($q) use ($categoryIds) {
                        //     $q->whereHas('tags', function ($q) use ($categoryIds) {
                        //         $q->whereIn('id', $categoryIds);
                        //     });
                        // })
                        // ->when($request->input('text'), function ($q) use ($request) {
                        //     $q->where('name', 'LIKE', '%' . $request->input('text') . '%');
                        // })
                        // ->when($request->input('favorite'), function ($q) use ($request) {
                        //     $q->where('favorite', 1);
                        // })
                        // ->when($request->input('label_id'), function ($q) use ($request) {
                        //     $q->whereHas('labels', function ($q) use ($request) {
                        //         $q->where('id', $request->input('label_id'));
                        //     });
                        // })
                        // ->when($request->input('sort-raiting'), function ($q) {
                        //     $q->where('star','>=','4');
                        // })
                        // ->when($request->input('date'), function ($q) use ($startDate, $endDate) {
                        //     $q->where(function ($q) use ($startDate, $endDate) {
                        //         $q
                        //             ->where(function ($q) use ($startDate, $endDate) {
                        //                 $q
                        //                     ->whereDate('start', '<=', $startDate)
                        //                     ->whereDate('end', '>', $startDate);
                        //             })
                        //             ->orWhere(function ($q) use ($startDate, $endDate) {
                        //                 $q
                        //                     ->whereDate('start', '<', $endDate)
                        //                     ->whereDate('end', '>=', $endDate);
                        //             })
                        //             ->orWhere(function ($q) use ($startDate, $endDate) {
                        //                 $q
                        //                     ->whereDate('start', '>=', $startDate)
                        //                     ->whereDate('end', '<=', $endDate);
                        //             });
                        //     });
                        // })
                        ->whereHas('addresses', function ($q) use ($city) {
                            // $q->when($location, function ($q) use ($location, $request) {
                            //     $q->isWithinMaxDistance($location, $request->input('location.range') / 1000);
                            // })
                            $q->where('city_id', $city->id);
                        })
                        ->active();

        $categories = Category::whereHas('companies', function ($q) use ($query, $city) {
                $q->whereHas('events', function($q) use ($city, $query) {
                    $q->whereHas('addresses', function ($q) use ($city) {
                        $q->where('city_id', $city->id);
                    })->active();
            });
        })->orderBy('name')->get(['id', 'name', 'slug']); 

        $tagsForNavigation = CategoriesTag::when($tag->category, function($q) use ($tag) {
            $q->whereHas('category', function($q) use ($tag) {
                $q->where('id', $tag->category->id);
            });
        })->whereHas('events', function($q) use ($city, $query) {
            $q->whereHas('addresses', function ($q) use ($city) {
                $q->where('city_id', $city->id);
            })->active();
        })->orderBy('order')->get(['id', 'name', 'slug', 'category_id', 'order']);

        $tagsForModal = CategoriesTag::whereHas('events', function($q) use ($city, $query) {
            $q->whereHas('addresses', function ($q) use ($city) {
                $q->where('city_id', $city->id);
            })->active();
        })->orderBy('order')->get(['id', 'name', 'slug', 'category_id', 'order']);
        // отсортированные эвенты для показа в списке
        // if ($request->input('sort-views')) {

        //     $query->orderBy('views', $request->input('sort-views'));

        //     $requestInput['Сортировано по:'] = 'просмотрам';

        // }

        // if ($request->input('sort-raiting')) {
        //     $query->orderBy('star', $request->input('sort-raiting'))->take(32);

        //     $requestInput['Сортировано по:'] = 'рейтингу';

        // }

        SEOTools::setTitle(!is_null($tag->eventSeo) && !is_null($tag->eventSeo->title) ?  str_replace(array("city", "tag"), array($city->name, $tag->name), $tag->eventSeo->title) : 'Скидки и акции в г.'.$city->name);
        SEOTools::setDescription(!is_null($tag->eventSeo) && !is_null($tag->eventSeo->description) ? str_replace(array("city", "tag"), array($city->name, $tag->name), $tag->eventSeo->description) : 'Выгодные акции и скидки в г.'.$city->name);

        SEOTools::opengraph()->setUrl(url()->current());
        SEOTools::opengraph()->setType('website');
        SEOTools::opengraph()->setSiteName('Dailyes');
        SEOTools::opengraph()->addImage(!is_null($tag->image_url) && !is_null($tag->image_url) ? $tag->image_url : env('APP_URL') . '/images/logo.png');

        SEOTools::jsonLd()->setType('website');
        SEOTools::jsonLd()->setTitle(!is_null($tag->eventSeo) && !is_null($tag->eventSeo->title) ?  str_replace(array("city", "tag"), array($city->name, $tag->name), $tag->eventSeo->title) : 'Скидки и акции в г.'.$city->name);
        SEOTools::jsonLd()->setDescription(!is_null($tag->eventSeo) && !is_null($tag->eventSeo->description) ? str_replace(array("city", "tag"), array($city->name, $tag->name), $tag->eventSeo->description) : 'Выгодные акции и скидки в г.'.$city->name);
        SEOTools::jsonLd()->setSite('Dailyes');
        SEOTools::jsonLd()->setUrl(url()->current());
        SEOTools::jsonLd()->addImage(!is_null($tag->eventSeo) && !is_null($tag->image_url) ? $tag->image_url : env('APP_URL') . '/images/logo.png');

        $events = $query->select('id', 'name', 'slug', 'star', 'views', 'rec', 'favorite', 'company_id', 'image_download_id', 'start', 'end')
            ->with([
                'labels:id,name,icon_download_id',
                'tags:id,slug,name',
                'company:id,slug,name',
                'image:path,id',
                'addresses:id,company_id,address'
            ]);

        if($request->ajax() && is_null($request->input('page'))){
            $events = $events->get();
            // адреса для карты
            $addresses = $query->with([
                            'addresses:id,company_id,lat,long,city_id,address',
                            'addresses.events' => function($q) {
                                $q->select('id', 'name', 'slug', 'star', 'views', 'rec', 'favorite', 'company_id', 'image_download_id', 'start', 'end')->active();
                            }, 
                            'addresses.events.company:id,name,slug', 
                            'addresses.company:id,name,slug',
                            'addresses.events.tags'])
                        ->get()
                        ->reduce(function ($carry, $item) use ($city) {
                                    $add = $item->addresses->filter(function ($item) use ($city) {
                                        return $item->city_id == $city->id;
                                    });
                                    return $carry->merge($add);
                                }, collect());

            foreach ($events as $key => $event) {
                $event->statusFavorite = Auth()->user() ? Auth()->user()->favorite_events->contains('id', $event->id) : false;
                foreach ($event->addresses as $event_address) {
                    if ($event_address->city_id == $city->id) {
                        $current_address = $event_address->address;
                    }
                }
                $event->addressString1 = ($event->addresses->count() > 0 ? (isset($current_address) ? $current_address : $event->addresses[0]->address) : '') . ($event->addresses->count() > 1 ? ' и еще ' : '');
                $event->addressString2 = ($event->addresses->count() > 1 ? ($event->addresses->count() - 1). ' ' . pular(($event->addresses->count() - 1), ['адрес', 'адреса', 'адресов']) : '');
                if (empty($event->image) || !Storage::exists($event->image->path)) {
                    $event->image_url = 'http://via.placeholder.com/285x300';
                }
                $event->image_url =  Storage::url($event->image->path);
            }
            foreach ($addresses as $key => $address) {
                foreach ($address->events as $key => $event) {
                    $event->statusFavorite = Auth()->user() ? Auth()->user()->favorite_events->contains('id', $event->id) : false;
                    foreach ($address->company->addresses as $company_address) {
                        if ($company_address->city_id == $city->id) {
                            $current_address = $company_address->address;
                        }
                    }
                    $address->company->addressString1 = ($address->company->addresses->count() > 0 ? (isset($current_address) ? $current_address : $address->company->addresses[0]->address) : '') . ($address->company->addresses->count() > 1 ? ' и еще ' : '');
                    $address->company->addressString2 = ($address->company->addresses->count() > 1 ? ($address->company->addresses->count() - 1). ' ' . pular(($address->company->addresses->count() - 1), ['адрес', 'адреса', 'адресов']) : '');
                    if (empty($event->image) || !Storage::exists($event->image->path)) {
                        $event->image_url = 'http://via.placeholder.com/285x300';
                    }
                    $event->image_url =  Storage::url($event->image->path);
                }
            }
            return response()->json([
                'tags' => $tagsForModal,
                'tag' => $tag,
                // 'category' => $category,
                'events' => $events->toArray(),
                'addresses' => $addresses,
                'categories' => $categories,
                'newTab' => $query->whereHas('labels', function ($q) use ($request) {
                    $q->where('id', 1);
                })->get()->count() > 0,
                'endTab' => $query->whereHas('labels', function ($q) use ($request) {
                    $q->where('id', 2);
                })->get()->count() > 0
            ]);
        }


            return view('frontend.city.event.tag.show')
            // ->withSelection($selection)
            // ->withCity($city)
            ->withTagsForNavigation($tagsForNavigation)
            ->withTagsForModal($tagsForModal)
            ->withTag($tag)
            ->withEvents($events->paginate($request->input('pagination.per_page') ?? 32))
            // ->withAddresses($addresses)
            ->withCategories($categories)
            ->withEventListOnePlace(BannerPlace::where('key', 'event-list-one')->with([
                'activeBanners' => function ($q) use ($city) {
                    $q->whereHas('city', function ($q) use ($city) {
                        $q->where('id', $city->id);
                    })->inRandomOrder();
                }, 'activeBanners.download', 'activeBanners.mobile'
            ])->first())
            ->withEventListSecondPlace(BannerPlace::where('key', 'event-list-second')->with([
                'activeBanners' => function ($q) use ($city) {
                    $q->whereHas('city', function ($q) use ($city) {
                        $q->where('id', $city->id);
                    })->inRandomOrder();
                }, 'activeBanners.download', 'activeBanners.mobile'
            ])->first())
            ->withEventListTreePlace(BannerPlace::where('key', 'event-list-tree')->with([
                'activeBanners' => function ($q) use ($city) {
                    $q->whereHas('city', function ($q) use ($city) {
                        $q->where('id', $city->id);
                    })->inRandomOrder();
                }, 'activeBanners.download', 'activeBanners.mobile'
            ])->first())
            ->withNewTab($query->whereHas('labels', function ($q) use ($request) {
                $q->where('id', 1);
            })->get()->count() > 0)
            ->withEndTab($query->whereHas('labels', function ($q) use ($request) {
                $q->where('id', 2);
            })->get()->count() > 0);
            // ->withRequestInput($requestInput);

        // }

    }
}
