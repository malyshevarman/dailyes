<?php

namespace App\Listeners\Comment;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Events\Comment\Updated;
use App\Notifications\Comment\commentPublishedForEventOrCompanyOwner;
use App\Notifications\Comment\commentPublishedForAuthor;
use App\Notifications\Comment\CommentRejected;

class SendCommentListener
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
     * @param  \App\Events\Comment\Updated  $event
     * @return void
     */
    public function handle(Updated $event)
    {
        if ($user = $event->comment->commented->user) {
            if ($event->comment->published && !$event->comment->rejected && $event->comment->is_moderated) {
                if (!$user->hasRole('admin')) {
                    $user->notify(new commentPublishedForEventOrCompanyOwner($event->comment));
                }
                if ($event->comment->user && !$event->comment->user->hasRole('admin')) {
                    $event->comment->user->notify(new commentPublishedForAuthor($event->comment));
                }
            }

            if ($event->comment->rejected) {
                if ($event->comment->user && !$event->comment->user->hasRole('admin')) {
                    $event->comment->user->notify(new CommentRejected($event->comment));
                }
            }
        }
    }
}
