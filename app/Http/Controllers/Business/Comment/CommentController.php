<?php

namespace App\Http\Controllers\Business\Comment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = \Auth::user();

        $companies = $user->companies()->has('comments')->with(['comments'])->get();
        $events = $user->events()->has('comments')->with(['comments'])->get();

        return view('business.comment.index')
            ->withCompanies($companies)
            ->withEvents($events);
    }

    public function show()
    {
        return view('business.comment.show');
    }
}
