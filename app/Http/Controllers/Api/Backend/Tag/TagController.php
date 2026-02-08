<?php

namespace App\Http\Controllers\Api\Backend\Tag;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\CategoriesTag;
use App\CompanyCategoriesTag;
use App\EventCategoriesTag;
use App\Seo;
use App\Download;
use Storage;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function filter(Request $request)
    {
        $query = CategoriesTag::query();

        if ($request->search) {
            $query->where('name', 'LIKE', '%' . $request->search . '%');
        }

        $items = $query->orderBy($request->input('orderBy.column'), $request->input('orderBy.direction'))
            ->paginate($request->input('pagination.per_page'));

        return $items;
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(CategoriesTag $tag)
    {
        return [
            'tag' => $tag->load(['background', 'image']),
            'seoEvent' => EventCategoriesTag::find($tag->id)->seo,
            'seoCompany' => CompanyCategoriesTag::find($tag->id)->seo,
        ];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CategoriesTag $tag)
    {
        $validData = $this->validate($request, [
            'tag.name' => 'required|string|unique:categories_tags,name,' . $request['tag']['id'],
            'tag.slug' => 'nullable|string|unique:categories_tags,slug,' . $request['tag']['id'],
            'tag.background.id' => 'required|exists:downloads,id',
            'tag.image.id' => 'required|exists:downloads,id',
            'seoCompany.id' => 'nullable',
            'seoCompany.title' => 'nullable',
            'seoCompany.description' => 'nullable',
            'seoCompany.page_text' => 'nullable',
            'seoCompany.h1' => 'required|string',
            'seoEvent.id' => 'nullable',
            'seoEvent.title' => 'nullable',
            'seoEvent.description' => 'nullable',
            'seoEvent.page_text' => 'nullable',
            'seoEvent.h1' => 'required|string',
            'tag.order' => 'nullable|numeric'
        ]);
        $tag->fill($validData['tag']);
        // $category->fill($validData['category']);
        if (isset($tag->image) && $tag->image->id !== $validData['tag']['image']['id']) {
            Storage::disk('public')->delete($tag->image->path);
            $image = Download::find($tag->image->id);
        }

        if (isset($tag->background) && $tag->background->id !== $validData['tag']['background']['id']) {
            Storage::disk('public')->delete($tag->background->path);
            $background = Download::find($tag->background->id);
        }
        $tag->image()->associate(Download::find($validData['tag']['image']['id']));
        $tag->background()->associate(Download::find($validData['tag']['background']['id']));

        // $category->tags()->detach();
        $tag->save();
        // foreach ($validData['category']['tags'] as $key => $tag) {
        //     // dd($tag);
        //     $categoriesTag = CategoriesTag::firstOrCreate($tag);
        //     // dd($categoriesTag);
        //     $category->tags()->attach($categoriesTag->id);
        // }
        isset($image) ?? $image->delete();
        isset($background) ?? $background->delete();
        // $seoEvent = Seo::create($validData['seoEvent']);
        // $seoEvent->save();
        // $seoCompany = Seo::make($validData['seoCompany']);
        // $seoCompany->save();
        $eventCategoryTag = EventCategoriesTag::find($tag->id);
        $companyCategoryTag = CompanyCategoriesTag::find($tag->id);
        if ($eventCategoryTag->seo) {
            $eventCategoryTag->seo()->update($validData['seoEvent']);
        } else {
            $eventCategoryTag->seo()->save(Seo::create($validData['seoEvent']));
        }

        if ($companyCategoryTag->seo) {
            $companyCategoryTag->seo->update($validData['seoCompany']);
        } else {
            $companyCategoryTag->seo()->save(Seo::create($validData['seoCompany']));
        }

        return [
            'tag' => $tag->load(['background', 'image']),
            'seoEvent' => EventCategoriesTag::find($tag->id)->seo,
            'seoCompany' => CompanyCategoriesTag::find($tag->id)->seo
        ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
