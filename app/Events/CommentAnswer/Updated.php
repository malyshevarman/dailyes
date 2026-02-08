<?php

namespace App\Events\CommentAnswer;

use App\CommentAnswer;
// use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
// use Illuminate\Broadcasting\PrivateChannel;
// use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
// use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class Updated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * The comment instance.
     *
     * @var \App\CommentAnswer
     */
    public $answer;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(CommentAnswer $comment)
    {
        $this->comment = $comment;
    }

}
