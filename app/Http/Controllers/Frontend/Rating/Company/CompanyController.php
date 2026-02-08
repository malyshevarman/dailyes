<?php

namespace App\Http\Controllers\Frontend\Rating\Company;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Slide;
use App\Category as Category;
use App\Company;
use App\CategoriesTag;
use Artesaos\SEOTools\Facades\SEOTools;

class CompanyController extends Controller
{
    public function show(CategoriesTag $tag) {
    	$city = city();
    	// $companies = $category->companies()->orderBy('star', 'desc')->take(10)->get();
    	$query = Company::when($tag, function ($q) use ($tag) {
                $q->whereHas('tags', function ($q) use ($tag) {
                    $q->where('id', $tag->id);
                });
            })
            ->whereHas('addresses', function ($q) use ($city) {
                $q->where('city_id', $city->id);
            })
            ->active()->orderBy('star', 'desc')->take(10);

    	$addresses = (clone $query)->with('addresses.company')->get()->reduce(function ($carry, $item) use ($city) {
                    $add = $item->addresses->filter(function ($item) use ($city) {
                        return $item->city_id == $city->id;
                    });
                    return $carry->merge($add);
                }, collect());

        $companies = (clone $query)->with('image')->get();



        SEOTools::setTitle(!is_null($tag->slide) ?  str_replace(array("city", "tag"), array($city->name, $tag->name), $tag->slide->title) : $tag->slide->name);
        SEOTools::setDescription(!is_null($tag->slide) ? str_replace(array("city", "tag"), array($city->name, $tag->name), $tag->slide->description) : $tag->slide->summary);

        SEOTools::opengraph()->setUrl(url()->current());
        SEOTools::opengraph()->setType('website');
        SEOTools::opengraph()->setSiteName('Dailyes');
        SEOTools::opengraph()->addImage($tag->slide ?? env('APP_URL') . '/images/logo.png');

        SEOTools::jsonLd()->setType('website');
        SEOTools::jsonLd()->setTitle(!is_null($tag->slide) ?  str_replace(array("city", "tag"), array($city->name, $tag->name), $tag->slide->title) : $tag->slide->name);
        SEOTools::jsonLd()->setDescription(!is_null($tag->slide) ? str_replace(array("city", "tag"), array($city->name, $tag->name), $tag->slide->description) : $tag->slide->summary);
        SEOTools::jsonLd()->setSite('Dailyes');
        SEOTools::jsonLd()->setUrl(url()->current());
        SEOTools::jsonLd()->addImage($tag->slide ?? env('APP_URL') . '/images/logo.png');

    	return view('frontend.city.company.tag.rating.show')
                // ->withCity($city)
    			->withTag($tag->load('slide'))
    			->withAddresses($addresses)
    			->withCompanies($companies)
    			->withCategories(Category::all());
    }
}
