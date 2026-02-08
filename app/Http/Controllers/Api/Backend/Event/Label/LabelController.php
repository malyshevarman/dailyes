<?php

namespace App\Http\Controllers\Api\Backend\Event\Label;

use App\Download;
use App\EventLabel as Label;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LabelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function filter(Request $request)
    {
        $query = Label::query();

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
            'name' => 'required|string|unique:event_labels,name',
            'icon.id' => 'required|exists:downloads,id',
        ]);

        $label = Label::make($validData);
        $label->icon()->associate(Download::find($validData['icon']['id']));
        $label->save();

        return $label;
    }

    /**
     * Display the specified resource.
     *
     * @param Label $label
     * @return \Illuminate\Http\Response
     */
    public function show(Label $label)
    {
        return $label;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param Label $label
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, Label $label)
    {
        $validData = $this->validate($request, [
            'name' => 'required|string|unique:event_labels,name,' . $request->id,
            'icon.id' => 'required|exists:downloads,id',
        ]);

        $label->fill($validData);
        $label->icon()->associate(Download::find($validData['icon']['id']));
        $label->save();

        return $label;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Label $label
     * @return int
     */
    public function destroy(Label $label)
    {
        return Label::destroy($label->id);
    }

    public function all()
    {
        return Label::all();
    }
}
