<?php

namespace App\Http\Controllers\Frontend\Rating\Event;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Tile;
use App\Category as Category;
use App\Event;
use App\CategoriesTag;
use Artesaos\SEOTools\Facades\SEOTools;

class EventController extends Controller
{
    public function show(CategoriesTag $tag) {
    	$city = city();
    	// $companies = $category->companies()->orderBy('star', 'desc')->take(10)->get();
    	$query = Event::when($tag, function ($q) use ($tag) {
            $q->whereHas('tags', function ($q) use ($tag) {
                $q->where('id', $tag->id);
            });
        })
            ->whereHas('addresses', function ($q) use ($city) {
                $q->where('city_id', $city->id);
            })
            // ->with('addresses')
            ->active()->orderBy('star', 'desc')->take(10);

        $events = (clone $query)->with('image')->get();

    	$addresses = (clone $query)->with(
                ['addresses.events', 'addresses.events.company:id,name', 'addresses.company:id,name'])->get()->reduce(function ($carry, $item) use ($city) {
                    $add = $item->addresses->filter(function ($item) use ($city) {
                        return $item->city_id == $city->id;
                    });
                    return $carry->merge($add);
                }, collect());
                

        SEOTools::setTitle(!is_null($tag->tile->title) ?  str_replace(array("city", "tag"), array($city->name, $tag->name), $tag->tile->title) : $tag->tile->name);
        SEOTools::setDescription(!is_null($tag->tile->description) ? str_replace(array("city", "tag"), array($city->name, $tag->name), $tag->tile->description) : $tag->tile->summary);

        SEOTools::opengraph()->setUrl(url()->current());
        SEOTools::opengraph()->setType('website');
        SEOTools::opengraph()->setSiteName('Dailyes');
        SEOTools::opengraph()->addImage($tag->tile->image_url ?? env('APP_URL') . '/images/logo.png');

        SEOTools::jsonLd()->setType('website');
        SEOTools::jsonLd()->setTitle(!is_null($tag->tile->title) ?  str_replace(array("city", "tag"), array($city->name, $tag->name), $tag->tile->title) : $tag->tile->name);
        SEOTools::jsonLd()->setDescription(!is_null($tag->tile->description) ? str_replace(array("city", "tag"), array($city->name, $tag->name), $tag->tile->description) : $tag->tile->summary);
        SEOTools::jsonLd()->setSite('Dailyes');
        SEOTools::jsonLd()->setUrl(url()->current());
        SEOTools::jsonLd()->addImage($tag->tile->image_url ?? env('APP_URL') . '/images/logo.png');


    	return view('frontend.city.event.tag.rating.show')
                // ->withCity($city)
    			->withTag($tag->load('tile'))
    			->withAddresses($addresses)
    			->withEvents($events)
    			->withCategories(Category::all());
    }
}
