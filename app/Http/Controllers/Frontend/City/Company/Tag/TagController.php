<?php

namespace App\Http\Controllers\Frontend\City\Company\Tag;

use App\CategoriesTag;
use App\BannerPlace;
use App\City;
use App\Company;
use App\Address;
use App\Selection;
use App\Category as Category;
use App\Http\Controllers\Controller;
use Artesaos\SEOTools\Facades\SEOTools;
// use GoogleMaps;
use Illuminate\Http\Request;
use Storage;

class TagController extends Controller
{
    public function show(Request $request, CategoriesTag $tag)
    {
        if (!is_null($request->input('page')) && !is_numeric($request->input('page'))) {
            return redirect($request->url());
        }
        $city = city();
        //Строка для вывода параметров фильтра на фронт
        // $requestInput = [];
        // $categoryIds = [];
        // $location = null;

        // if ($request->input('tags') && is_array($request->input('tags'))) {
        //     $categoryIds = $request->input('tags');
        //     $categories_names = Category::whereIn('id', $categoryIds)->get(['id', 'name'])->toArray();
        //     $requestInput['Категории:'] = $categories_names;
        // }

        // if (!is_null($request->input('location.name')) || !is_null($request->input('location.coords'))) {
        //     $api = new \Yandex\Geo\Api();
        //     $api->setToken('f679a5dd-9081-411e-abf2-ac4a32c74e0c');
        //     if (!empty($request->input('location.name'))) {
        //         $api->setQuery($request->input('location.name'));
        //     }
        //     if (!empty($request->input('location.coords'))) {
        //         $coords = explode(',', $request->input('location.coords'));
        //         $api->setPoint($coords[1], $coords[0]);
        //     }
        //     $api->setLimit(1)// кол-во результатов
        //     ->setLang(\Yandex\Geo\Api::LANG_RU)// локаль ответа
        //     ->load();
        //     $response = $api->getResponse();

        //     $location = new \stdClass();
        //     $location->lat = $response->getList()[0]->getLatitude();
        //     $location->lng = $response->getList()[0]->getLongitude();
        //     $query->whereHas('addresses', function ($query) use ($request, $location) {
        //         $query->isWithinMaxDistance($location, $request->input('location.range') / 1000);
        //     });
        //     $requestInput['Адрес:'] = $request->input('location.name');
        // }

        // TODO встроить фильтры
        $query = Company::when($tag, function ($q) use ($tag) {
                            $q->whereHas('tags', function ($q) use ($tag) {
                                $q->where('id', $tag->id);
                            });
                        })
                        // ->when($request->input('text'), function ($q) use ($request) {
                        //     $q->where('name', 'LIKE', '%' . $request->input('text') . '%');
                        // })
                        // ->when($request->input('tags') && is_array($request->input('tags')), function ($q) use ($categoryIds) {
                        //     $q->whereHas('tags', function ($q) use ($categoryIds) {
                        //         $q->whereIn('id', $categoryIds);
                        //     });
                        // })
                        // ->when($request->input('sort-raiting'), function ($q) {
                        //     $q->where('star','>=','4');
                        // })
                        ->whereHas('addresses', function ($q) use ($city) {
                            // $q->when($location, function ($q) use ($location, $request) {
                            //     $q->isWithinMaxDistance($location, $request->input('location.range') / 1000);
                            // })
                            $q->where('city_id', $city->id);
                        })
                        // ->with('addresses')
                        ->active();

        $categories = Category::whereHas('companies', function($q) use ($city) {
            $q->whereHas('addresses', function ($q) use ($city) {
                $q->where('city_id', $city->id);
            })->active();
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
        // if ($request->input('sort-raiting')) {
        //     $query->orderBy('star', $request->input('sort-raiting'))->take(32);
        //     $requestInput['Сортировано по:'] = 'рейтингу';
        // } else {
            $query->orderBy('created_at', 'desc');
        // }

        SEOTools::setTitle(!is_null($tag->companySeo) && !is_null($tag->companySeo->title) ?  str_replace(array("city", "tag"), array($city->name, $tag->name), $tag->companySeo->title) : 'Компании в г.'.$city->name);
        SEOTools::setDescription(!is_null($tag) && !is_null($tag->companySeo->description) ? str_replace(array("city", "tag"), array($city->name, $tag->name), $tag->companySeo->description) : 'Компании в г.'.$city->name);

        SEOTools::opengraph()->setUrl(url()->current());
        SEOTools::opengraph()->setType('website');
        SEOTools::opengraph()->setSiteName('Dailyes');
        SEOTools::opengraph()->addImage(!is_null($tag->image_url) && !is_null($tag->image_url) ? $tag->image_url : env('APP_URL') . '/images/logo.png');

        SEOTools::jsonLd()->setType('website');
        SEOTools::jsonLd()->setTitle(!is_null($tag->companySeo) && !is_null($tag->companySeo->title) ?  str_replace(array("city", "tag"), array($city->name, $tag->name), $tag->companySeo->title) : 'Компании в г.'.$city->name);
        SEOTools::jsonLd()->setDescription(!is_null($tag->companySeo) && !is_null($tag->companySeo->description) ? str_replace(array("city", "tag"), array($city->name, $tag->name), $tag->companySeo->description) : 'Компании в г.'.$city->name);
        SEOTools::jsonLd()->setSite('Dailyes');
        SEOTools::jsonLd()->setUrl(url()->current());
        SEOTools::jsonLd()->addImage(!is_null($tag->image_url) && !is_null($tag->image_url) ? $tag->image_url : env('APP_URL') . '/images/logo.png');


            $companies = $query->select('id', 'name', 'slug', 'about', 'star', 'views', 'rec', 'image_download_id')->with(['image:path,id', 'tags:id,slug,name', 'addresses:id,company_id,address']);

            if($request->ajax() && is_null($request->input('page'))){
                $companies = $companies->get();
                $addresses = $query->with(
                                    ['addresses:id,company_id,lat,long,city_id,address',
                                    'addresses.company' => function($q) {
                                        $q->select('id', 'name', 'slug', 'about', 'star', 'views', 'rec', 'image_download_id')->active();
                                    },
                                    'addresses.company.image:path,id',
                                    'addresses.company.tags',
                                    'addresses.company.addresses:id,company_id,address'])->get()->reduce(function ($carry, $item) use ($city) {
                                        $add = $item->addresses->filter(function ($item) use ($city) {
                                            return $item->city_id == $city->id;
                                        });
                                        return $carry->merge($add);
                                    }, collect());
                
                foreach ($companies as $key => $company) {
                    $company->status = Auth()->user() ? Auth()->user()->favorite_companies->contains('id', $company->id) : false;
                    foreach ($company->addresses as $company_address) {
                        if ($company_address->city_id == $city->id) {
                            $current_address = $company_address->address;
                        }
                    }
                    $company->addressString1 = ($company->addresses->count() > 0 ? (isset($current_address) ? $current_address : $company->addresses[0]->address) : '') . ($company->addresses->count() > 1 ? ' и еще ' : '');
                    $company->addressString2 = ($company->addresses->count() > 1 ? ($company->addresses->count() - 1). ' ' . pular(($company->addresses->count() - 1), ['адрес', 'адреса', 'адресов']) : '');
                    if (empty($company->image) || !Storage::exists($company->image->path)) {
                        $company->image_url = 'http://via.placeholder.com/285x300';
                    } else {
                        $company->image_url =  Storage::url($company->image->path);
                    }
                }
                foreach ($addresses as $key => $address) {
                    $address->company->status = Auth()->user() ? Auth()->user()->favorite_companies->contains('id', $address->company->id) : false;
                    foreach ($address->company->addresses as $company_address) {
                        if ($company_address->city_id == $city->id) {
                            $current_address = $company_address->address;
                        }
                    }
                    $address->company->addressString1 = ($address->company->addresses->count() > 0 ? (isset($current_address) ? $current_address : $address->company->addresses[0]->address) : '') . ($address->company->addresses->count() > 1 ? ' и еще ' : '');
                    $address->company->addressString2 = ($address->company->addresses->count() > 1 ? ($address->company->addresses->count() - 1). ' ' . pular(($address->company->addresses->count() - 1), ['адрес', 'адреса', 'адресов']) : '');
                    if (empty($address->company->image) || !Storage::exists($address->company->image->path)) {
                        $address->company->image_url = 'http://via.placeholder.com/285x300';
                    } else {
                        $address->company->image_url =  Storage::url($address->company->image->path);
                    }
                    
                }
                return response()->json([
                    'tags' => $tagsForModal,
                    'tag' => $tag,
                    // 'category' => $category,
                    'companies' => $companies->toArray(),
                    'addresses' => $addresses,
                    'categories' => $categories
                ]);
            }

            return view('frontend.city.company.tag.show')
                // ->withSelection($selection)
                // ->withCity($city)
                ->withTagsForNavigation($tagsForNavigation)
                ->withTagsForModal($tagsForModal)
                ->withTag($tag)
                ->withCompanies($companies->paginate($request->input('pagination.per_page') ?? 32))
                // ->withAddresses($addresses)
                ->withCategories($categories)
                ->withCompanyListOnePlace(BannerPlace::where('key', 'company-list-one')->with([
                    'activeBanners' => function ($query) use ($city) {
                        $query->whereHas('city', function ($query) use ($city) {
                            $query->where('id', $city->id);
                        })->inRandomOrder();
                    }, 'activeBanners.download', 'activeBanners.mobile'
                ])->first())
                ->withCompanyListSecondPlace(BannerPlace::where('key', 'company-list-second')->with([
                    'activeBanners' => function ($query) use ($city) {
                        $query->whereHas('city', function ($query) use ($city) {
                            $query->where('id', $city->id);
                        })->inRandomOrder();
                    }, 'activeBanners.download', 'activeBanners.mobile'
                ])->first())
                ->withCompanyListTreePlace(BannerPlace::where('key', 'company-list-tree')->with([
                    'activeBanners' => function ($query) use ($city) {
                        $query->whereHas('city', function ($query) use ($city) {
                            $query->where('id', $city->id);
                        })->inRandomOrder();
                    }, 'activeBanners.download', 'activeBanners.mobile'
                ])->first());
                // ->withRequestInput($requestInput);

        // }

    }
}
