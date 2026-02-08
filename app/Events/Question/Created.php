<?php

namespace App\Events\Question;

use App\Question;
use App\Notifications\Question\QuestionCreated;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class Created
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @param Question $question
     */
    public function __construct(Question $question)
    {
        if ($user = $question->event->user) {
            $user->notify(new QuestionCreated($question));
        }
    }
}
