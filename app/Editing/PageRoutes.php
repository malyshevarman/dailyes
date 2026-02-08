<?php

namespace App\Editing;

use App\Http\Controllers\Frontend\Page\PageController;
use App\Page;
use App\Article;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class PageRoutes
{
    public function routes()
    {
        $this->pages()->each(function (Page $page) {
            Route::get($page->path, function () use ($page) {
                return App::make(PageController::class)->callAction('dynamic', ['page' => $page]);
            })->name(str_replace('/', '.', 'page' . Str::snake($page->path)));
            if ($page->name == "Блог") {
                $articles = Article::all();
                $articles->each(function ($article) use ($page) {
                    Route::get($page->path . '/' . $article->slug, function () use ($page, $article) {
                        return App::make(PageController::class)->callAction('dynamicNews', ['page' => $page, 'article' => $article]);
                    })->name(str_replace('/', '.', 'page' . Str::snake($page->path) . '/show'));
                });
            }
        });
    }

    private function pages()
    {
        return Cache::remember(
            'pages_routes',
            Carbon::now()->addWeek(),
            function () {
                try {
                    $pages = Page::all();
                    return $pages;
                } catch (\Exception $exception) {
                    return new Collection();
                }
            }
        );
    }
}
