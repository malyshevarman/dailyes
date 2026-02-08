<?php

namespace App\Http\Controllers\Api\Backend\Tile;

use App\City;
// use App\Selection;
use App\Tile;
use App\Category as Category;
use App\Download;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Storage;
use App\CategoriesTag;

class TileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function filter(Request $request)
    {
        $query = Tile::query();

        if ($request->search['text']) {
            $query->where('name', 'LIKE', '%' . $request->search['text'] . '%');
        }

        if (!empty($request->search['city'])) {
            $city_id = $request->search['city'];
            if ($city_id !== 0) {
                $query->where('city_id', $city_id);
            }
        }

        $items = $query->with(['category', 'city'])->orderBy($request->input('orderBy.column'), $request->input('orderBy.direction'))
            ->paginate($request->input('pagination.per_tile'));

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
            'image.id' => 'nullable|exists:downloads,id',
            // 'selection.id' => 'required|exists:selections,id',
            'city.id' => 'nullable|exists:cities,id',
            'category.id' => 'nullable|exists:categories,id',
            'categories_tag.id' => 'nullable|exists:categories_tags,id',
            'events' => 'nullable',
            'events.*.id' => 'exists:events,id',
            'companies' => 'nullable',
            'companies.*.id' => 'exists:companies,id',
            'start' => 'nullable|date_format:Y-m-d H:i:s',
            'end' => 'nullable|date_format:Y-m-d H:i:s',
            'title' => 'nullable',
            'description' => 'nullable',
            'text' => 'nullable'
        ]);

        $tile = Tile::make($validData);
        if (isset($validData['image'])) {
            $image = Download::find($validData['image']['id']);
            $tile->image()->associate($image);
        }

        // $selection = Selection::find($validData['selection']['id']);

        // $tile->selection()->associate($selection);

        if (isset($validData['category'])) {
            $category = Category::find($validData['category']['id']);
            $tile->category()->associate($category);
        }

        if (isset($validData['categories_tag'])) {
            $tag = CategoriesTag::find($validData['categories_tag']['id']);
            $tile->categoriesTag()->associate($tag);
        }

        if (isset($validData['city'])) {
            $tile->city()->associate(City::find($validData['city']['id']));
        }

        $tile->save();

        $tile->events()->sync($validData['events'] ? array_map(function ($item) {
            return $item['id'];
        }, $validData['events']) : []);

        $tile->companies()->sync($validData['companies'] ? array_map(function ($item) {
            return $item['id'];
        }, $validData['companies']) : []);
        
        return $tile->load([
            'events',
            'companies',
            'category',
            'category.tags',
            'categoriesTag',
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param Tile $tile
     * @return \Illuminate\Http\Response
     */
    public function show(Tile $tile)
    {
        return $tile->load([
            // 'selection',
            'events',
            'companies',
            'city',
            'category',
            'category.tags',
            'categoriesTag',
            'image'
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param Tile $tile
     * @return Tile
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, Tile $tile)
    {
        $validData = $this->validate($request, [
            'name' => 'required|string',
            'summary' => 'required|string',
            'image.id' => 'nullable|exists:downloads,id',
            // 'selection.id' => 'required|exists:selections,id',
            'city.id' => 'nullable|exists:cities,id',
            'category.id' => 'nullable|exists:categories,id',
            'categories_tag.id' => 'nullable|exists:categories_tags,id',
            'events' => 'nullable',
            'events.*.id' => 'exists:events,id',
            'companies' => 'nullable',
            'companies.*.id' => 'exists:companies,id',
            'start' => 'nullable|date_format:Y-m-d H:i:s',
            'end' => 'nullable|date_format:Y-m-d H:i:s',
            'title' => 'nullable',
            'description' => 'nullable',
            'text' => 'nullable'
        ]);

        $tile->fill($validData);
        if (isset($validData['image'])) {
            if ($tile->image->id !== $validData['image']['id']) {
                Storage::disk('public')->delete($tile->image->path);
                $image = Download::find($tile->image->id);
            }
            $tile->image()->associate(Download::find($validData['image']['id']));   
        }

        // $selection = Selection::find($validData['selection']['id']);

        // $tile->selection()->associate($selection);
        $tile->events()->sync($validData['events'] ? array_map(function ($item) {
            return $item['id'];
        }, $validData['events']) : []);

        $tile->companies()->sync($validData['companies'] ? array_map(function ($item) {
            return $item['id'];
        }, $validData['companies']) : []);

        if (isset($validData['category'])) {
            $category = Category::find($validData['category']['id']);
            $tile->category()->associate($category);
        }

        if (isset($validData['categories_tag'])) {
            $tag = CategoriesTag::find($validData['categories_tag']['id']);
            $tile->categoriesTag()->associate($tag);
        }

        if (isset($validData['city'])) {
            $tile->city()->associate(City::find($validData['city']['id']));
        }

        $tile->save();
        isset($image) ?? $image->delete();
        return $tile->load([
            'events',
            'companies',
            'category',
            'category.tags',
            'categoriesTag',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Tile $tile
     * @return int
     */
    public function destroy(Tile $tile)
    {
        return Tile::destroy($tile->id);
    }
}
