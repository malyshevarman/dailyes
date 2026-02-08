<?php

namespace App\Http\Controllers\Backend\Comment;

use App\Http\Controllers\Controller;

class CommentController extends Controller
{
    public function index()
    {
        return view('backend.comment.index');
    }
}
