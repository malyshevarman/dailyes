<?php

namespace App\Http\Controllers\Backend\Comment\Answer;

use App\Http\Controllers\Controller;

class AnswerController extends Controller
{
    public function index()
    {
        return view('backend.comment.answer.index');
    }
}
