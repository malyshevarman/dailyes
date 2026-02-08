<?php

namespace App\Http\Controllers\Api\Cabinet\Question\Answer;

use App\Question;
use App\QuestionAnswer as Answer;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AnswerController extends Controller
{
    public function store(Request $request, Question $question)
    {
        $validData = $this->validate($request, [
            'parent.id' => 'nullable|exists:question_answers,id',
            'text' => 'required|string'
        ]);

        $answer = Answer::make([
            'text' => $validData['text']
        ]);

        empty($validData['parent']) ?: $answer->parent()->associate($validData['parent']['id']);
        $answer->question()->associate($question);
        $answer->user()->associate(\Auth::user());
        $answer->save();

        return 'ok';
    }
}
