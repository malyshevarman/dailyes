<?php

namespace App\Events\Comment;

use App\Comment;
// use App\Event;
use App\Notifications\Comment\CommentCreated;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class Created
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @param Comment $comment
     */
    public function __construct(Comment $comment)
    {
        if ($user = $comment->commented->user) {
            $user->notify(new CommentCreated($comment));
        }
    }
}
