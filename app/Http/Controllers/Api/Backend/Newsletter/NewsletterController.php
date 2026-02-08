<?php

namespace App\Http\Controllers\Api\Backend\Newsletter;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Newsletter;
class NewsletterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function filter(Request $request)
    {
        $query = Newsletter::query();

        if ($request->search) {
            $query->where('subject', 'LIKE', '%' . $request->search . '%');
        }

        $items = $query->orderBy($request->input('orderBy.column'), $request->input('orderBy.direction'))
            ->paginate($request->input('pagination.per_page'));

        return $items;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validData = $this->validate($request, [
            'subject' => 'required|string',
            'text' => 'required|string',
            'data' => 'required|array',
        ]);

        $newsletter = Newsletter::create($validData);

        return $newsletter;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Newsletter $newsletter)
    {
        return $newsletter;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Newsletter $newsletter)
    {
        $validData = $this->validate($request, [
            'subject' => 'required|string',
            'text' => 'required|string',
            'data' => 'required|array',
        ]);

        $newsletter->update($validData);

        return $newsletter;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Newsletter $newsletter)
    {
        return Newsletter::destroy($newsletter->id);
    }

    public function toggleIsActive(Newsletter $newsletter)
    {
        $newsletter->is_active = !$newsletter->is_active;
        $newsletter->save();
        return $newsletter;
    }
}
