<?php

namespace App\Http\Controllers\Api\Backend\Selection;

use App\Selection;
use App\Download;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SelectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function filter(Request $request)
    {
        $query = Selection::query()->with('tile', 'tile.city', 'slide', 'slide.city');

        if (!empty($request->search['text'])) {
            $query->where('name', 'LIKE', '%' . $request->search['text'] . '%');
        }

        if (!empty($request->search['city'])) {
            $city_id = $request->search['city'];
            if ($city_id !== 0) {
                $query->whereHas('tile', function ($q) use ($city_id) {
                    $q->where('city_id', $city_id);
                })->orWhereHas('slide', function ($q) use ($city_id) {
                    $q->where('city_id', $city_id);
                });
            }
        }

        $items = $query->orderBy($request->input('orderBy.column'), $request->input('orderBy.direction'))
            ->paginate($request->input('pagination.per_selection'));

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
            'name' => 'required|string|unique:selections,name',
            'events' => 'nullable',
            'events.*.id' => 'exists:events,id',
            'companies' => 'nullable',
            'companies.*.id' => 'exists:companies,id',
            'params' => 'array',
            'params.*.*' => 'required',
            'background.id' => 'required|exists:downloads,id',
        ]);

        $selection = Selection::create($validData);

        $selection->events()->sync($validData['events'] ? array_map(function ($item) {
            return $item['id'];
        }, $validData['events']) : []);

        $selection->companies()->sync($validData['companies'] ? array_map(function ($item) {
            return $item['id'];
        }, $validData['companies']) : []);
        $selection->background()->associate(Download::find($validData['background']['id']));
        return $selection->load([
            'events',
            'companies'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param Selection $selection
     * @return \Illuminate\Http\Response
     */
    public function show(Selection $selection)
    {
        return $selection->load([
            'events',
            'companies',
            'background'
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param Selection $selection
     * @return Selection
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, Selection $selection)
    {
        $validData = $this->validate($request, [
            'name' => 'required|string|unique:selections,name,' . $request->id,
            'events' => 'nullable',
            'events.*.id' => 'exists:events,id',
            'companies' => 'nullable',
            'companies.*.id' => 'exists:companies,id',
            'params' => 'array',
            'params.*.*' => 'required',
            'background.id' => 'required|exists:downloads,id',
        ]);

        $selection->fill($validData);

        $selection->events()->sync($validData['events'] ? array_map(function ($item) {
            return $item['id'];
        }, $validData['events']) : []);

        $selection->companies()->sync($validData['companies'] ? array_map(function ($item) {
            return $item['id'];
        }, $validData['companies']) : []);
        $selection->background()->associate(Download::find($validData['background']['id']));
        $selection->save();

        return $selection->load([
            'events',
            'companies'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Selection $selection
     * @return int
     */
    public function destroy(Selection $selection)
    {
        return Selection::destroy($selection->id);
    }

    public function all()
    {
        return Selection::all();
    }
}
