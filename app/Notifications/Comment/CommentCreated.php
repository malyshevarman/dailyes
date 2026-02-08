<?php

namespace App\Notifications\Comment;

use App\Comment;
use App\Company;
use App\Event;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class CommentCreated extends Notification
{
    use Queueable;

    public $comment;
    public $event;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        if ($this->comment->commented_type == Event::class) {
            return [
                'text' => "На вашу акцию <a href='" . route('frontend.event.show', $this->comment->commented) . "'>" . $this->comment->commented->name . "</a> поступил <a href='" . route('cabinet.comment.show',  $this->comment) . "'>отзыв</a>",
                'id' => $this->comment->commented_id,
                'type' => Event::class,
                'comment_id' => $this->comment->id
            ];
        } else if ($this->comment->commented_type == Company::class) {
            return [
                'text' => "На вашу компанию <a href='" . route('frontend.company.show', $this->comment->commented) . "'>" . $this->comment->commented->name . "</a> поступил <a href='" . route('cabinet.comment.show',  $this->comment) . "'>отзыв</a>",
                'id' => $this->comment->commented_id,
                'type' => Company::class,
                'comment_id' => $this->comment->id
            ];
        }

        return [];
    }
}
