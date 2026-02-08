<?php

namespace App\Http\Controllers\Api\Backend\Category;

use App\Category as Category;
use App\Download;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Storage;
use App\EventCategory;
use App\CompanyCategory;
use App\Seo;
use App\CategoriesTag;
use Illuminate\Support\Arr;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function filter(Request $request)
    {
        $query = Category::query();

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
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $validData = $this->validate($request, [
            'category.name' => 'required|string|unique:categories,name',
            'category.slug' => 'nullable|string|unique:categories,slug',
            'category.background.id' => 'required|exists:downloads,id',
            'category.image.id' => 'required|exists:downloads,id',
            'category.order' => 'nullable|integer',
            // 'seoCompany.title' => 'nullable',
            // 'seoCompany.description' => 'nullable',
            // 'seoCompany.page_text' => 'nullable',
            // 'seoCompany.h1' => 'required|string',
            // 'seoEvent.title' => 'nullable',
            // 'seoEvent.description' => 'nullable',
            // 'seoEvent.page_text' => 'nullable',
            // 'seoEvent.h1' => 'required|string',
            'category.tags' => 'required|array'
        ]);

        $category = Category::make($validData['category']);
        $category->image()->associate(Download::find($validData['category']['image']['id']));
        $category->background()->associate(Download::find($validData['category']['background']['id']));
        $category->save();
        foreach ($validData['category']['tags'] as $key => $tag) {
            $categoriesTag = CategoriesTag::make($tag);
            $categoriesTag->category()->associate($category->id);
            $categoriesTag->save();
            // $category->tags()->associa($categoriesTag);
        }
        // dd(Seo::create($validData['seoEvent']));
        // EventCategory::find($category->id)->seo()->save(Seo::create($validData['seoEvent']));
        // CompanyCategory::find($category->id)->seo()->save(Seo::create($validData['seoCompany']));

        return [
            'category' => $category->load(['background', 'image', 'tags']),
            // 'seoEvent' => EventCategory::find($category->id)->seo,
            // 'seoCompany' => CompanyCategory::find($category->id)->seo
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param Category $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        return [
            'category' => $category->load(['background', 'image', 'tags']),
            // 'seoEvent' => EventCategory::find($category->id)->seo,
            // 'seoCompany' => CompanyCategory::find($category->id)->seo,
        ];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param Category $category
     * @return Category
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, Category $category)
    {
        // dd($request);
        $validData = $this->validate($request, [
            'category.name' => 'required|string|unique:categories,name,' . $request['category']['id'],
            'category.slug' => 'nullable|string|unique:categories,slug,' . $request['category']['id'],
            'category.background.id' => 'required|exists:downloads,id',
            'category.image.id' => 'required|exists:downloads,id',
            'category.order' => 'nullable|integer',
            // 'seoCompany.id' => 'nullable',
            // 'seoCompany.title' => 'nullable',
            // 'seoCompany.description' => 'nullable',
            // 'seoCompany.page_text' => 'nullable',
            // 'seoCompany.h1' => 'required|string',
            // 'seoEvent.id' => 'nullable',
            // 'seoEvent.title' => 'nullable',
            // 'seoEvent.description' => 'nullable',
            // 'seoEvent.page_text' => 'nullable',
            // 'seoEvent.h1' => 'required|string',
            'category.tags' => 'required|array'
        ]);

        $category->fill($validData['category']);
        if ($category->image->id !== $validData['category']['image']['id']) {
            Storage::disk('public')->delete($category->image->path);
            $image = Download::find($category->image->id);
        }

        if ($category->background->id !== $validData['category']['background']['id']) {
            Storage::disk('public')->delete($category->background->path);
            $background = Download::find($category->background->id);
        }
        $category->image()->associate(Download::find($validData['category']['image']['id']));
        $category->background()->associate(Download::find($validData['category']['background']['id']));

        // $category->tags()->detach();
        $category->save();

        foreach ($category->tags as $key => $value) {
            if (!in_array($value->id, Arr::pluck($validData['category']['tags'], 'id'))) {
                $value->delete();
            }
        }
        foreach ($validData['category']['tags'] as $key => $tag) {
            // dd($tag);
            if (isset($tag['id'])) {
                $categoriesTag = CategoriesTag::find($tag['id']);
            } else {
                $categoriesTag = CategoriesTag::make($tag);
            }
            $categoriesTag->category()->associate($category->id);
            $categoriesTag->save();
        }
        isset($image) ?? $image->delete();
        isset($background) ?? $background->delete();
        
        // $eventCategory = EventCategory::find($category->id);
        // $companyCategory = CompanyCategory::find($category->id);
        // if ($eventCategory->seo) {
        //     $eventCategory->seo()->update($validData['seoEvent']);
        // } else {
        //     $eventCategory->seo()->save(Seo::create($validData['seoEvent']));
        // }

        // if ($companyCategory->seo) {
        //     $companyCategory->seo->update($validData['seoCompany']);
        // } else {
        //     $companyCategory->seo()->save(Seo::create($validData['seoCompany']));
        // }

        return [
            'category' => $category->load(['background', 'image', 'tags']),
            // 'seoEvent' => EventCategory::find($category->id)->seo,
            // 'seoCompany' => CompanyCategory::find($category->id)->seo
        ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Category $category
     * @return int
     */
    public function destroy(Category $category)
    {
        return Category::destroy($category->id);
    }

    public function all()
    {
        return Category::orderBy('name')->get()->load(['tags']);
    }
}
