<?php

namespace App\Http\Controllers\Api\Backend\Banner\Place;

use App\BannerPlace as Place;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PlaceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function filter(Request $request)
    {
        $query = Place::query();

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
            'name' => 'required|string|unique:banner_places,name',
            'key' => 'nullable|string|unique:banner_places,key',
            'width' => 'required|integer',
            'height' => 'required|integer',

        ]);

        $place = Place::make($validData);
        $place->save();

        return $place;
    }

    /**
     * Display the specified resource.
     *
     * @param Place $place
     * @return \Illuminate\Http\Response
     */
    public function show(Place $place)
    {
        return $place;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param Place $place
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, Place $place)
    {
        $validData = $this->validate($request, [
            'name' => 'required|string|unique:banner_places,name,' . $request->id,
            'key' => 'nullable|string|unique:banner_places,key,' . $request->id,
            'width' => 'required|integer',
            'height' => 'required|integer',
        ]);

        $place->fill($validData);
        $place->save();

        return $place;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Place $place
     * @return int
     * @throws \Exception
     */
    public function destroy(Place $place)
    {
        return response()->json($place->delete());
    }

    public function all()
    {
        return Place::all();
    }
}
