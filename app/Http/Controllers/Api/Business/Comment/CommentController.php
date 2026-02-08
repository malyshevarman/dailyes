<?php

namespace App\Http\Controllers\Api\Business\Comment;

use App\Comment;
use App\Http\Controllers\Controller;

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
        if ($comment->commented->user->id != \Auth::id()) {
            return response()->json(['error' => 'Not authorized.'], 403);
        }

        return $comment->load([
            'user',
            'answers',
            'answers.user'
        ]);
    }
}
