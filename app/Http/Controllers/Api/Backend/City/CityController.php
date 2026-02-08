<?php

namespace App\Http\Controllers\Api\Backend\City;

use App\City;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function filter(Request $request)
    {
        $query = City::query();

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
            'name' => 'required|string|unique:cities,name',
            'slug' => 'nullable|string|unique:cities,slug',
            'lat' => 'required|numeric',
            'long' => 'required|numeric',
            'timezone' => 'nullable|timezone'
        ]);

        $city = City::create($validData);

        return $city;
    }

    /**
     * Display the specified resource.
     *
     * @param City $city
     * @return \Illuminate\Http\Response
     */
    public function show(City $city)
    {
        return $city;
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
            'name' => 'required|string|unique:cities,name,' . $request->id,
            'slug' => 'nullable|string|unique:cities,slug,' . $request->id,
            'lat' => 'required|numeric',
            'long' => 'required|numeric',
            'timezone' => 'nullable|timezone'
        ]);

        $city = City::find($request->id);

        $city->update($validData);

        return $city;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param City $city
     * @return int
     */
    public function destroy(City $city)
    {
        return City::destroy($city->id);
    }

    public function all()
    {
        return City::whereHas('addresses', function($q) {
            $q->has('company');
        })->orderBy('name')->get();
    }
}
