<?php

namespace App\Notifications\CommentAnswer;

use Illuminate\Support\Facades\Lang;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\CommentAnswer;
use App\Event;
use App\Company;

class CommentAnswerCreatedForCommentAuthor extends Notification
{
    use Queueable;

    public $answer;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($answer)
    {
        $this->answer = $answer;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        if ($this->answer->comment->commented_type == Event::class) {
            $subject = "Комментарий на оставленный отзыв по акции";
        } else if ($this->answer->comment->commented_type == Company::class) {
            $subject = "Комментарий на оставленный отзыв по компании";
        }

        return (new MailMessage)
            ->subject(Lang::getFromJson($subject))
            // ->line(Lang::getFromJson('Пожалуйста, нажмите кнопку ниже, чтобы подтвердить свой адрес электронной почты.'))
            // ->action(Lang::getFromJson('Подтвердить регистрацию'), $verificationUrl)
            // ->line(Lang::getFromJson('Если вы не создали учетную запись, никаких дальнейших действий не требуется.'))
            ->view('notifications.commentAnswer.commentAnswerCreatedForCommentAuthor', ['data' => ['answer' => $this->answer, 'user' => $notifiable]]);
    }

    // /**
    //  * Get the array representation of the notification.
    //  *
    //  * @param  mixed  $notifiable
    //  * @return array
    //  */
    // public function toArray($notifiable)
    // {
    //     return [
    //         //
    //     ];
    // }
}
