<?php

namespace App\Http\Controllers\Api\Backend\Slide;

use App\City;
use App\Download;
// use App\Selection;
use App\Slide;
use App\Category as Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Storage;
use App\CategoriesTag;

class SlideController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function filter(Request $request)
    {
        $query = Slide::query();

        if ($request->search['text']) {
            $query->where('name', 'LIKE', '%' . $request->search['text'] . '%');
        }

        if (!empty($request->search['city'])) {
            $city_id = $request->search['city'];
            if ($city_id !== 0) {
                $query->where('city_id', $city_id);
            }
        }

        $items = $query->with(['city', 'category'])->orderBy($request->input('orderBy.column'), $request->input('orderBy.direction'))
            ->paginate($request->input('pagination.per_slide'));

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
            'name' => 'required|string',
            'summary' => 'required|string',
            'button' => 'required|string',
            'image.id' => 'required|exists:downloads,id',
            // 'selection.id' => 'nullable|exists:selections,id',
            'city.id' => 'nullable|exists:cities,id',
            'category.id' => 'nullable|exists:categories,id',
            'categories_tag.id' => 'nullable|exists:categories_tags,id',
            'title' => 'nullable',
            'description' => 'nullable',
            'text' => 'nullable'
        ]);

        $slide = Slide::make($validData);

        $image = Download::find($validData['image']['id']);
        $slide->image()->associate($image);

        // if (isset($validData['selection'])) {
        //     $selection = Selection::find($validData['selection']['id']);
        //     $slide->selection()->associate($selection);
        // }

        if (isset($validData['category'])) {
            $category = Category::find($validData['category']['id']);
            $slide->category()->associate($category);
        }

        if (isset($validData['categories_tag'])) {
            $tag = CategoriesTag::find($validData['categories_tag']['id']);
            $slide->categoriesTag()->associate($tag);
        }

        if (isset($validData['city'])) {
            $slide->city()->associate(City::find($validData['city']['id']));
        }

        $slide->save();

        return $slide->load([
            'category',
            'category.tags',
            'categoriesTag',
            'image',
            'city'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param Slide $slide
     * @return \Illuminate\Http\Response
     */
    public function show(Slide $slide)
    {
        return $slide->load([
            'category',
            'category.tags',
            'categoriesTag',
            'image',
            'city'
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param Slide $slide
     * @return Slide
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, Slide $slide)
    {
        $validData = $this->validate($request, [
            'name' => 'required|string',
            'summary' => 'required|string',
            'button' => 'required|string',
            'image.id' => 'required|exists:downloads,id',
            // 'selection.id' => 'nullable|exists:selections,id',
            'city.id' => 'nullable|exists:cities,id',
            'category.id' => 'nullable|exists:categories,id',
            'categories_tag.id' => 'nullable|exists:categories_tags,id',
            'title' => 'nullable',
            'description' => 'nullable',
            'text' => 'nullable'
        ]);

        $slide->fill($validData);

        if ($slide->image->id !== $validData['image']['id']) {
            Storage::disk('public')->delete($slide->image->path);
            $image = Download::find($slide->image->id);
        }
        $slide->image()->associate(Download::find($validData['image']['id']));

        // if (isset($validData['selection'])) {
        //     $selection = Selection::find($validData['selection']['id']);
        //     $slide->selection()->associate($selection);
        // }

        if (isset($validData['category'])) {
            $category = Category::find($validData['category']['id']);
            $slide->category()->associate($category);
        }

        if (isset($validData['categories_tag'])) {
            $tag = CategoriesTag::find($validData['categories_tag']['id']);
            $slide->categoriesTag()->associate($tag);
        }

        if (isset($validData['city'])) {
            $slide->city()->associate(City::find($validData['city']['id']));
        }

        $slide->save();
        isset($image) ?? $image->delete();
        return $slide->load([
            'category',
            'category.tags',
            'categoriesTag',
            'image',
            'city'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Slide $slide
     * @return int
     */
    public function destroy(Slide $slide)
    {
        return Slide::destroy($slide->id);
    }
}
