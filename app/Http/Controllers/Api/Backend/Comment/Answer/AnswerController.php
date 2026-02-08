<?php

namespace App\Http\Controllers\Api\Backend\Comment\Answer;

use App\CommentAnswer as Answer;
use App\Comment;
use App\Event;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AnswerController extends Controller
{
    public function filter(Request $request)
    {
        $query = Answer::with([
            'user',
            'comment',
            'comment.commented'
        ]);

        if (!empty($request->search['text'])) {
            $query->where('name', 'LIKE', '%' . $request->search['text'] . '%');
        }
        
        if (!empty($request->search['city'])) {
            $city_name = $request->search['city'];
            if ($city_name !== 0) {
                $query->whereHas('user', function ($q) use ($city_name) {
                    $q->where('city', 'LIKE', '%' . $city_name . '%');
                });
            }
        }
        
        if ($request->typerewiews == "company") {
            
           $items = $query->whereHas(
                'comment', function ($q) {
                    $q->whereHasMorph(
                        'commented',
                        'App\Company'
                    );
                });
           $items = $query->orderBy($request->input('orderBy.column'), $request->input('orderBy.direction'))
                ->paginate($request->input('pagination.per_page'));

            return $items;

        } else {

            $items = $query->whereHas(
                'comment', function ($q) {
                    $q->whereHasMorph(
                        'commented',
                        'App\Event'
                    );
                })->get();
            $comment_id = [];
            foreach ($items as $key => $item) {
                $comment_id[] = $item->comment_id;
            }
            $comments = Comment::whereIn('id', $comment_id)
                        ->whereHasMorph(
                            'commented',
                            'App\Event'
                        )->get();
            $commented_id = [];
            foreach ($comments as $key => $comment) {
                $commented_id[] = $comment->commented_id;
            }
            $events = Event::whereIn('id', $commented_id)
                            ->with(['company'])
                            ->orderBy($request->input('orderBy.column'), $request->input('orderBy.direction'))
                            ->get();

            $items = $query->orderBy($request->input('orderBy.column'), $request->input('orderBy.direction'))
                ->paginate($request->input('pagination.per_page'));

            return response()->json([
                'answers' => $items,
                'events' => $events
            ]);

        }

    }

    public function destroy(Answer $answer)
    {
        return Answer::destroy($answer->id);
    }

    public function togglePublished(Request $request, Answer $answer)
    {
        $answer->published = !$answer->published;
        if ($answer->published) {
            $answer->rejected = false;
            $answer->message = null;
        }
        $answer->save();

        return 'ok';
    }

    public function toggleRejected(Request $request, Answer $answer)
    {
        $answer->rejected = !$answer->rejected;
        if ($answer->rejected) {
            $answer->published = false;
        } else {
            $answer->published = true;
            $answer->message = null;
        }
        $answer->save();

        return 'ok';
    }


    public function updateText(Request $request, Answer $answer) {
        $answer->update([
            'text' => $request->text
        ]);

        return response()->json([
                'status' => 'ok'
        ]);
    }

    public function moderate(Request $request, Answer $answer) {
        $answer->update([
            'is_moderated' => true
        ]);

        return response()->json([
            'status' => 'ok'
        ]);
    }

    public function updateMessage(Request $request, Answer $answer) {
        $answer->update([
            'message' => $request->message
        ]);

        return response()->json([
                'status' => 'ok'
        ]);
    }
}
