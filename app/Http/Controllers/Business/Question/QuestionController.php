<?php

namespace App\Http\Controllers\Business\Question;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class QuestionController extends Controller
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

        $events = $user->events()->has('questions')->with(['questions'])->get();

        return view('business.question.index')
            ->withEvents($events);
    }

    public function show()
    {
        return view('business.question.show');
    }
}
