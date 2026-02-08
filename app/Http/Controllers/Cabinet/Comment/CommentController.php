<?php

namespace App\Http\Controllers\Cabinet\Comment;

use App\Company;
use App\Event;
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



        $companies = Company::whereHas('comments', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->paginate(10);


        $events = Event::whereHas('comments', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->paginate(10);

        return view('cabinet.comment.index')
            ->withCompanies($companies)
            ->withEvents($events);
    }

    public function show()
    {
        return view('cabinet.comment.show');
    }
}
