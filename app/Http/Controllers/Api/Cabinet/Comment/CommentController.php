<?php

namespace App\Http\Controllers\Api\Cabinet\Comment;

use App\Comment;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param Comment $comment
     * @return \Illuminate\Http\Response
     */
    public function show(Comment $comment)
    {


        return $comment->load([
            'user',
            'answers',
            'answers.user'
        ]);
    }

    public function update(Request $request, Comment $comment)
    {
        $comment->fill($request->all());
        $comment->rejected = false;
        $comment->is_moderated = false;
        $comment->save();

        return $comment->load([
            'user',
            'answers',
            'answers.user'
        ]);
    }
}
