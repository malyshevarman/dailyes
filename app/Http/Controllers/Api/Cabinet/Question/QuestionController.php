<?php

namespace App\Http\Controllers\Api\Cabinet\Question;

use App\Question;
use App\Http\Controllers\Controller;

class QuestionController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param Question $question
     * @return \Illuminate\Http\Response
     */
    public function show(Question $question)
    {
        if ($question->user->id != \Auth::id()) {
            return response()->json(['error' => 'Not authorized.'], 403);
        }

        return $question->load([
            'user',
            'answers',
            'answers.user'
        ]);
    }
}
