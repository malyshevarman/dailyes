<?php

namespace App\Http\Controllers\Api\Backend\Subscriber;

use App\Subscriber;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SubscriberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function filter(Request $request)
    {
        $query = Subscriber::query();

        if ($request->search) {
            $query->where('email', 'LIKE', '%' . $request->search . '%');
        }

        $items = $query->orderBy($request->input('orderBy.column'), $request->input('orderBy.direction'))
            ->paginate($request->input('pagination.per_subscriber'));

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
            'email' => 'required|email|unique:subscribers,email'
        ]);

        $subscriber = Subscriber::create($validData);

        return $subscriber;
    }

    /**
     * Display the specified resource.
     *
     * @param Subscriber $subscriber
     * @return \Illuminate\Http\Response
     */
    public function show(Subscriber $subscriber)
    {
        return Subscriber::findOrFail($subscriber);
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
            'email' => 'required|email|unique:subscribers,email,' . $request->id
        ]);

        $subscriber = Subscriber::find($request->id);

        $subscriber->update($validData);

        return $subscriber;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Subscriber $subscriber
     * @return int
     */
    public function destroy(Subscriber $subscriber)
    {
        return Subscriber::destroy($subscriber->id);
    }

    public function subscriber()
    {
        return Subscriber::count();
    }
}
