<?php

namespace App\Http\Controllers\Frontend\Company;

use App\BannerPlace;
use App\Company;
use App\CommentAnswer as Answer;
use App\Comment;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Frontend\City\Company\Category\CategoryController;
use Artesaos\SEOTools\Facades\SEOTools;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function index(Request $request)
    {
        return resolve(CategoryController::class)->show($request, null);
    }

    public function show(Request $request, Company $company)
    {



        if ($company->active == true && $company->published == true) {
            $city = city();

            $company->load([
                'addresses' => function ($query) {
                    $query->orderBy('city_id', 'asc');
                },
                'addresses.city',
                // 'addresses.events',
                'addresses.company',
                'active_events',
                'completed_events',
                'views_today',
                // 'category',
                'comments',
                'comments.user',
                'comments.answers',
                'comments.answers.user',
                'gallery_items',
                'gallery_items.attachable',
                // 'selections'
            ]);

          // dd($company->image_url);



            SEOTools::setTitle('Компания '.$company->name.' | в г.'.$city->name);
            SEOTools::setDescription($company->about);

            SEOTools::opengraph()->setUrl(url()->current());
            SEOTools::opengraph()->setType('website');
            SEOTools::opengraph()->setSiteName('Dailyes');
            SEOTools::opengraph()->addImage($company->image_url);

            SEOTools::jsonLd()->setType('website');
            SEOTools::jsonLd()->setTitle('Компания в г.'.$city->name);
            SEOTools::jsonLd()->setDescription($company->about);
            SEOTools::jsonLd()->setSite('Dailyes');
            SEOTools::jsonLd()->setUrl(url()->current());
            SEOTools::jsonLd()->addImage($company->image_url);

            return view('frontend.company.show')
            // ->withCity($city)
            ->withCompany($company)
            ->withCompanyOnePlace(BannerPlace::where('key', 'company-one')->with([
                'activeBanners' => function ($query) use ($city) {
                    $query->whereHas('city', function ($query) use ($city) {
                        $query->where('id', $city->id);
                    })->inRandomOrder();
                }, 'activeBanners.download', 'activeBanners.mobile'
            ])->first())
            ->withCompanySecondPlace(BannerPlace::where('key', 'company-second')->with([
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
     * @param Company $company
     * @return false|\Illuminate\Database\Eloquent\Model
     * @throws \Illuminate\Validation\ValidationException
     */
    public function review(Request $request, Company $company)
    {
        $validData = $this->validate($request, [
            'thumb' => 'boolean',
            'rating' => 'between:1,5',
            'review' => 'required|string'
        ]);

        if (isset($request->rating)) {
            if (empty($company->user_rating)) {
                $company->ratings()->save($rating = auth()->user()->ratings()->make([
                    'star' => $validData['rating']
                ]));
            }
        }
        if (isset($request->thumb)) {
            if (empty($company->user_recommendation)) {
                $company->recommendations()->save($rating = auth()->user()->recommendations()->make([
                    'bool' => $validData['thumb']
                ]));
            }
        }
        $company->comments()->save($comment = auth()->user()->comments()->make([
            'text' => $validData['review'],
            // 'published' => 1
        ]));

        return back();
    }

    public function reviewAnswer(Request $request, Company $company, Comment $comment)
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

        return back();
    }

    /**
     * @param Request $request
     * @param Company $company
     * @return false|\Illuminate\Database\Eloquent\Model
     * @throws \Illuminate\Validation\ValidationException
     */
    public function report(Request $request, Company $company)
    {
        $validData = $this->validate($request, [
            'text' => 'nullable|string',
            'checkbox.*' => 'nullable|string',
        ]);

        $company->reports()->save($report = auth()->user()->reports()->make([
            'text' => $validData['text'] ?? '' . '; ' . implode('; ', $validData['checkbox'] ?? [])
        ]));

        return back();
    }
}
