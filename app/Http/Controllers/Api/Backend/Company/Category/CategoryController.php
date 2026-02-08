<?php

namespace App\Http\Controllers\Api\Backend\Company\Category;

use App\Category as Category;
use App\Download;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Storage;

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
            'name' => 'required|string|unique:categories,name',
            'slug' => 'nullable|string|unique:categories,slug',
            'background.id' => 'required|exists:downloads,id',
            'title' => 'nullable',
            'description' => 'nullable',
            'text' => 'nullable',
            'h1' => 'required|string'
        ]);

        $category = Category::make($validData);
        $category->background()->associate(Download::find($validData['background']['id']));
        $category->save();

        return $category;
    }

    /**
     * Display the specified resource.
     *
     * @param Category $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        return $category->load(['background']);
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
        $validData = $this->validate($request, [
            'name' => 'required|string|unique:categories,name,' . $request->id,
            'slug' => 'nullable|string|unique:categories,slug,' . $request->id,
            'background.id' => 'required|exists:downloads,id',
            'title' => 'nullable',
            'description' => 'nullable',
            'text' => 'nullable',
            'h1' => 'required|string'
        ]);

        $category->fill($validData);
        if ($category->background->id !== $validData['background']['id']) {
            Storage::disk('public')->delete($category->background->path);
            $background = Download::find($category->background->id);
        }
        $category->background()->associate(Download::find($validData['background']['id']));
        $category->save();
        isset($background) ?? $background->delete();
        return $category;
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
        return Category::orderBy('name')->get();
    }
}
