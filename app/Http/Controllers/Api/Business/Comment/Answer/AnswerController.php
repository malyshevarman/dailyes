<?php

namespace App\Http\Controllers\Api\Business\Comment\Answer;

use App\Comment;
use App\CommentAnswer as Answer;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AnswerController extends Controller
{
    public function store(Request $request, Comment $comment)
    {
        $validData = $this->validate($request, [
            'parent.id' => 'nullable|exists:comment_answers,id',
            'text' => 'required|string'
        ]);

        $answer = Answer::make([
            'text' => $validData['text']
        ]);

        empty($validData['parent']) ?: $answer->parent()->associate($validData['parent']['id']);
        $answer->comment()->associate($comment);
        $answer->user()->associate(\Auth::user());
        $answer->save();

        return 'ok';
    }

    public function update(Request $request, Comment $comment, Answer $answer)
    {
        $answer->fill($request->all());
        $answer->rejected = false;
        $answer->is_moderated = false;
        $answer->save();

        return $comment->load([
            'user',
            'answers',
            'answers.user'
        ]);
    }
}
