<?php

namespace App\Listeners\CommentAnswer;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Events\CommentAnswer\Updated;
use App\Notifications\CommentAnswer\CommentAnswerPublished;
use App\Notifications\CommentAnswer\CommentAnswerRejected;
use App\Notifications\CommentAnswer\CommentAnswerCreatedForCommentAuthor;
class SendCommentAnswerListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\CommentAnswer\Updated  $event
     * @return void
     */
    public function handle(Updated $event)
    {
        if ($user = $event->comment->user) {
            if ($event->comment->published && !$event->comment->rejected && $event->comment->is_moderated && $event->message == '') {
                if (!$user->hasRole('admin')) {
                    $user->notify(new CommentAnswerPublished($event->comment));
                }
                if (!$event->comment->comment->user->hasRole('admin')) {
                    $event->comment->comment->user->notify(new CommentAnswerCreatedForCommentAuthor($event->comment));
                }
            }

            if ($event->comment->rejected) {
                if (!$user->hasRole('admin')) {
                    $user->notify(new CommentAnswerRejected($event->comment));
                }
                
            }
        }
    }
}
