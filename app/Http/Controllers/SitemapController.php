<?php

namespace App\Http\Controllers;

use App\Article;
use App\City;
use App\Company;
use App\Event;
use App\Category;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Robots\Robots;

class SitemapController extends Controller
{
    public function sitemap()
    {
        $cityes = City::all();

        foreach ($cityes as $city) {
            $sitemap = \App::make("sitemap");

            $namecity = "https://" . ($city->slug !='moskva' ? $city->slug . '.' : '') . "dailyes.ru/";
            $sitemap->add($namecity, Carbon::now()->toIso8601String(), '1.0');
            $sitemap->add($namecity . 'about/', Carbon::now()->toIso8601String(), '0.9');
            $sitemap->add($namecity . 'jobs/', Carbon::now()->toIso8601String(), '0.9');
            $sitemap->add($namecity . 'help/', Carbon::now()->toIso8601String(), '0.9');
            $sitemap->add($namecity . 'contacts/', Carbon::now()->toIso8601String(), '0.9');
            $sitemap->add($namecity . 'ad/', Carbon::now()->toIso8601String(), '0.9');
            $sitemap->add($namecity . 'add-company/', Carbon::now()->toIso8601String(), '0.9');
            $sitemap->add($namecity . 'add-stocks/', Carbon::now()->toIso8601String(), '0.9');


            $groups = Event::all();
            foreach ($groups as $group) {
                $sitemap->add($namecity . 'stocks/' . $group->slug, Carbon::now()->toIso8601String(), '0.9');
            }


            $companies = Company::all();
            foreach ($companies as $group) {
                $sitemap->add($namecity . 'company/' . $group->slug, Carbon::now()->toIso8601String(), '0.9');
            }

            $blog = Article::all();
            foreach ($blog as $group) {
                $sitemap->add($namecity . 'blog/' . $group->slug, Carbon::now()->toIso8601String(), '0.9');
            }

            $sitemap->store('xml', ($city->slug !='moskva' ? $city->slug . '_' : '') . 'sitemap');
        }

    }
    public function robots()
    {

        $url = parse_url(url()->full());

        if ($url['host'] == '127.0.0.1' || $url['host'] == 'dailyes.ru') {
            $cityslug='';
        } else {
            $cityslug = explode('.', $url['host'])[0];

        }

        $robots = new Robots;
        $url = parse_url(url()->full());
        $robots->addUserAgent('*');
        $robots->addDisallow('/files/');
        $robots->addDisallow('/login');
        $robots->addDisallow('/register');
        $robots->addDisallow('/rules');
        $robots->addDisallow('/cabinet');
        $robots->addDisallow('/fonts/');
        $robots->addDisallow('/search');
        $robots->addDisallow('/*sort-raiting');
        $robots->addDisallow('/*sort-views');
        $robots->addDisallow('/*favorite');
        $robots->addDisallow('/*date');
        $robots->addDisallow('/*text');


        $robots->addSitemap('https://' . $url['host'] .'/' .($cityslug ? $cityslug. '_' : '') . 'sitemap.xml');
        $robots->addHost('https://' . $url['host']);

        return response($robots->generate(), 200)->header('Content-Type', 'text/plain');
    }


}
