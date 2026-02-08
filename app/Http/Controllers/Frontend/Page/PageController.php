<?php

namespace App\Http\Controllers\Frontend\Page;

use App\Company;
use App\Event;
use App\Http\Controllers\Controller;
use App\Page;
use App\Article;
use Artesaos\SEOTools\Facades\SEOTools;

class PageController extends Controller
{
    public function dynamic(Page $page)
    {
        $city = city();

if ($page->name == 'О сервисе') {
    SEOTools::setTitle('Dailyes – это сервис с ежедневными акциями и предложениями в г. '.$city->name.' и других городах России');
    SEOTools::setDescription($page->name);
} else {
    SEOTools::setTitle($page->name . ' | в г.' . $city->name);
    SEOTools::setDescription($page->name);
}


        SEOTools::opengraph()->setUrl(url()->current());
        SEOTools::opengraph()->setType('website');
        SEOTools::opengraph()->setSiteName('Dailyes');
        SEOTools::opengraph()->addImage(env('APP_URL') . '/images/share_link_logo_banner.png');

        SEOTools::jsonLd()->setType('website');
        SEOTools::jsonLd()->setTitle($page->name . ' | в г.' . $city->name);
        SEOTools::jsonLd()->setDescription($page->name);
        SEOTools::jsonLd()->setSite('Dailyes');
        SEOTools::jsonLd()->setUrl(url()->current());
        SEOTools::jsonLd()->addImage(env('APP_URL') . '/images/share_link_logo_banner.png');

        if ($page->name == 'Блог') {

            $articles = Article::orderBy('id', 'desc')->paginate(18);
            return view('frontend.page.blog.index')
                // ->withCity($city)
                ->withPage($page)
                ->withArticles($articles);

        } else if ($page->name == 'Для вашего бизнеса') {

            return view('frontend.page.business.index')
                // ->withCity($city)
                ->withPage($page);

        } else {
            return view('frontend.page.dynamic')
                // ->withCity($city)
                ->withPage($page);

        }
    }

    public function turbo()
    {
        $companies = Company::all();

        $events = Event::all();

        return response()->view('frontend.page.turbo', [
            'companies' => $companies,
            'events' => $events,
        ])->header('Content-Type', 'text/xml');
    }

    public function dynamicNews(Page $page, Article $article)
    {
        // $city = city();


        SEOTools::setTitle($article->title);
        SEOTools::setDescription($article->title);

        SEOTools::opengraph()->setUrl(url()->current());
        SEOTools::opengraph()->setType('website');
        SEOTools::opengraph()->setSiteName('Dailyes');
        SEOTools::opengraph()->addImage(env('APP_URL') . '/images/share_link_logo_banner.png');

        SEOTools::jsonLd()->setType('website');
        SEOTools::jsonLd()->setTitle($article->title);
        SEOTools::jsonLd()->setDescription($article->title);
        SEOTools::jsonLd()->setSite('Dailyes');
        SEOTools::jsonLd()->setUrl(url()->current());
        SEOTools::jsonLd()->addImage(env('APP_URL') . '/images/share_link_logo_banner.png');

        return view('frontend.page.blog.show')
            // ->withCity($city)
            ->withPage($page)
            ->withArticle($article);
        // return 'hi';
    }
}
