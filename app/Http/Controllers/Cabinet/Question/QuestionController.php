<?php

namespace App\Http\Controllers\Cabinet\Question;

use App\Event;
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

        $events = Event::has('questions')->with([
            'questions' => function ($query) use ($user) {
                $query->whereHas('user', function ($query) use ($user) {
                    $query->where('id', $user->id);
                });
            }])->get();

        return view('cabinet.question.index')
            ->withEvents($events);
    }

    public function show()
    {
        return view('cabinet.question.show');
    }
}
