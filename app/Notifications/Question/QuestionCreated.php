<?php

namespace App\Notifications\Question;

use App\Question;
use App\Event;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class QuestionCreated extends Notification
{
    use Queueable;

    public $question;
    public $event;

    /**
     * Create a new notification instance.
     *
     * @param Question $question
     */
    public function __construct(Question $question)
    {
        $this->question = $question;
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
        return [
            'text' => "На вашу акцию <a href='" . route('frontend.event.show', $this->question->event) . "'>" . $this->question->event->name . "</a> поступил <a href='" . route('cabinet.question.show', $this->question) . "'>вопрос</a>",
            'id' => $this->question->event->id,
            'type' => Event::class
        ];
    }
}
