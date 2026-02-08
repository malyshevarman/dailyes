<?php

namespace App\Http\Controllers\Api\Backend\Page;

use App\Page;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function filter(Request $request)
    {
        $query = Page::query();

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
            'name' => 'required|string|unique:pages,name',
            'path' => 'nullable|string|unique:pages,path',
            'view' => 'nullable',
            'title' => 'nullable',
            'description' => 'nullable',
            'breadcrumbs' => 'nullable',
            'h1' => 'nullable',
            'summary' => 'nullable',
            'content' => 'nullable'
        ]);

        $page = Page::create($validData);

        return $page;
    }

    /**
     * Display the specified resource.
     *
     * @param Page $page
     * @return \Illuminate\Http\Response
     */
    public function show(Page $page)
    {
        return $page;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request)
    {
        $validData = $this->validate($request, [
            'name' => 'required|string|unique:pages,name,' . $request->id,
            'path' => 'required|string|unique:pages,path,' . $request->id,
            'view' => 'nullable',
            'title' => 'nullable',
            'description' => 'nullable',
            'breadcrumbs' => 'nullable',
            'h1' => 'nullable',
            'summary' => 'nullable',
            'content' => 'nullable'
        ]);

        $page = Page::find($request->id);

        $page->update($validData);

        return $page;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Page $page
     * @return int
     */
    public function destroy(Page $page)
    {
        return Page::destroy($page->id);
    }
}
