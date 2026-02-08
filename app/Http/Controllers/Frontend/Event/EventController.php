<?php

namespace App\Http\Controllers\Frontend\Event;

use App\BannerPlace;
use App\Event;
use App\CommentAnswer as Answer;
use App\Comment;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Frontend\City\Event\Category\CategoryController;
use Artesaos\SEOTools\Facades\SEOTools;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index(Request $request)
    {
        return resolve(CategoryController::class)->show($request, null);
    }

    public function show(Request $request, Event $event)
    {

        if ($event->active == true && $event->published == true) {

            $city = city();
            $event->addView();
            $event->addRecentlyViewedList();




            SEOTools::setTitle('Акция ' . $event->name . ' | в г.' . $city->name);
            SEOTools::setDescription($event->about);

            SEOTools::opengraph()->setUrl(url()->current());
            SEOTools::opengraph()->setType('website');
            SEOTools::opengraph()->setSiteName('Dailyes');
            SEOTools::opengraph()->addImage($event->image_url);

            SEOTools::jsonLd()->setType('website');
            SEOTools::jsonLd()->setTitle('Акция в г.' . $city->name);
            SEOTools::jsonLd()->setDescription($event->about);
            SEOTools::jsonLd()->setSite('Dailyes');
            SEOTools::jsonLd()->setUrl(url()->current());
            SEOTools::jsonLd()->addImage($event->image_url);

            return view('frontend.event.show')
                // ->withCity($city)
                ->withEvent($event->load([
                    'addresses' => function ($query) {
                        $query->orderBy('city_id', 'asc');
                    },
                    'addresses.city',
                    'addresses.events',
                    'addresses.events.company',
                    'company',
                    'views_today',
                    // 'company.category',
                    'comments',
                    'comments.user',
                    'comments.answers',
                    'comments.answers.user',
                    'questions',
                    'questions.user',
                    'questions.answers',
                    'questions.answers.user',
                    'gallery_items',
                    'gallery_items.attachable',
                    'labels',
                    'rating_results',
                    // 'selections'
                ]))
                ->withEventOnePlace(BannerPlace::where('key', 'event-one')->with([
                    'activeBanners' => function ($query) use ($city) {
                        $query->whereHas('city', function ($query) use ($city) {
                            $query->where('id', $city->id);
                        })->inRandomOrder();
                    }, 'activeBanners.download', 'activeBanners.mobile'
                ])->first())
                ->withEventSecondPlace(BannerPlace::where('key', 'event-second')->with([
                    'activeBanners' => function ($query) use ($city) {
                        $query->whereHas('city', function ($query) use ($city) {
                            $query->where('id', $city->id);
                        })->inRandomOrder();
                    }, 'activeBanners.download', 'activeBanners.mobile'
                ])->first());
        } else {
            return response()->view('errors.404', [], 404);
        }
    }

    /**
     * @param Request $request
     * @param Event $event
     * @return false|\Illuminate\Database\Eloquent\Model
     * @throws \Illuminate\Validation\ValidationException
     */
    public function review(Request $request, Event $event)
    {
        $validData = $this->validate($request, [
            'thumb' => 'boolean',
            'rating' => 'between:1,5',
            'review' => 'required|string'
        ]);

        if (isset($request->rating)) {
            if (empty($event->user_rating)) {
                $event->ratings()->save($rating = auth()->user()->ratings()->make([
                    'star' => $validData['rating']
                ]));
            }
        }

        if (isset($request->thumb)) {
            if (empty($event->user_recommendation)) {
                $event->recommendations()->save($rating = auth()->user()->recommendations()->make([
                    'bool' => $validData['thumb']
                ]));
            }
        }
        $event->comments()->save($comment = auth()->user()->comments()->make([
            'text' => $validData['review'],
            // 'published' => 0
        ]));

        return response()->json(true, 201);
    }

    public function reviewAnswer(Request $request, Event $event, Comment $comment)
    {
        $validData = $this->validate($request, [
            'parent.id' => 'nullable|exists:comment_answers,id',
            'text' => 'required|string'
        ]);

        $answer = Answer::make([
            'text' => $validData['text']
        ]);

        empty($validData['parent']) ?: $answer->parent()->associate($validData['parent']['id']);
        $answer->comment()->associate($comment);
        $answer->user()->associate(\Auth::user());
        // dd($comment);
        $answer->save();

        return response()->json(true, 201);
    }

    // /**
    //  * @param Request $request
    //  * @param Event $event
    //  * @return false|\Illuminate\Database\Eloquent\Model
    //  * @throws \Illuminate\Validation\ValidationException
    //  */
    // public function question(Request $request, Event $event)
    // {
    //     $validData = $this->validate($request, [
    //         'review' => 'required|string'
    //     ]);

    //     $event->questions()->save($question = auth()->user()->questions()->make([
    //         'text' => $validData['review'],
    //         // 'published' => 0
    //     ]));

    //     return back();
    // }

    /**
     * @param Request $request
     * @param Event $event
     * @return false|\Illuminate\Database\Eloquent\Model
     * @throws \Illuminate\Validation\ValidationException
     */
    public function report(Request $request, Event $event)
    {
        $validData = $this->validate($request, [
            'text' => 'nullable|string',
            'checkbox.*' => 'nullable|string',
        ]);

        $event->reports()->save($report = auth()->user()->reports()->make([
            'text' => $validData['text'] ?? '' . '; ' . implode('; ', $validData['checkbox'] ?? [])
        ]));

        return back();
    }
}
