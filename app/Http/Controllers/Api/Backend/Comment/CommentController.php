<?php

namespace App\Http\Controllers\Api\Backend\Comment;

use App\Comment;
use App\Event;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class CommentController extends Controller
{
    public function filter(Request $request)
    {
        $query = Comment::with([
            'user'
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
            
           $items = $query->whereHasMorph(
                'commented',
                'App\Company'
            )->with('commented');
           $items = $query->orderBy($request->input('orderBy.column'), $request->input('orderBy.direction'))
                ->paginate($request->input('pagination.per_page'));

            return $items;

        } else {

            $items = $query->whereHasMorph(
                'commented',
                'App\Event'
            )->get();
            $commented_id = [];
            foreach ($items as $key => $item) {
                $commented_id[] = $item->commented_id;
            }
            $events = Event::whereIn('id', $commented_id)
                            ->with(['company'])
                            ->orderBy($request->input('orderBy.column'), $request->input('orderBy.direction'))
                            ->get();

            $items = $query->orderBy($request->input('orderBy.column'), $request->input('orderBy.direction'))
                ->paginate($request->input('pagination.per_page'));

            return response()->json([
                'comments' => $items,
                'events' => $events
            ]);

        }
    }

    public function destroy(Comment $comment)
    {
        foreach ($comment->commented->user->notifications as $key => $notification) {
            if (isset($notification->data['comment_id']) && $notification->data['comment_id'] == $comment->id) {
                $notification->delete();
            }
        }
        return Comment::destroy($comment->id);
    }

    public function togglePublished(Request $request, Comment $comment)
    {
        $comment->published = !$comment->published;
        if ($comment->published) {
            $comment->rejected = false;
            $comment->message = null;
        }
        $comment->save();

        return 'ok';
    }

    public function toggleRejected(Request $request, Comment $comment)
    {
        $comment->rejected = !$comment->rejected;
        if ($comment->rejected) {
            $comment->published = false;
        } else {
            $comment->published = true;
            $comment->message = null;
        }
        $comment->save();

        return 'ok';
    }

    public function updateText(Request $request, Comment $comment) {
        $comment->update([
            'text' => $request->text
        ]);

        return response()->json([
                'status' => 'ok'
        ]);
    }

    public function moderate(Request $request, Comment $comment) {
        $comment->update([
            'is_moderated' => true
        ]);

        return response()->json([
            'status' => 'ok'
        ]);
    }

    public function updateMessage(Request $request, Comment $comment) {
        $comment->update([
            'message' => $request->message
        ]);

        return response()->json([
                'status' => 'ok'
        ]);
    }
}
