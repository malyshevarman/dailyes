<?php

namespace App\Http\Controllers\Backend\Question\Answer;

use App\Http\Controllers\Controller;

class AnswerController extends Controller
{
    public function index()
    {
        return view('backend.question.answer.index');
    }
}
