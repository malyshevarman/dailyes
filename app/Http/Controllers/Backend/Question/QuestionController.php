<?php

namespace App\Http\Controllers\Backend\Question;

use App\Http\Controllers\Controller;

class QuestionController extends Controller
{
    public function index()
    {
        return view('backend.question.index');
    }
}
