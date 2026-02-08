<?php

namespace App\Notifications\Comment;

use Illuminate\Support\Facades\Lang;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Comment;
use App\Company;
use App\Event;

class commentPublishedForEventOrCompanyOwner extends Notification
{
    use Queueable;

    public $comment;

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
        // dd($this->comment->commented_type);
        if ($this->comment->commented_type == Event::class) {
            $subject = "Новый отзыв про вашу акцию";
        } else if ($this->comment->commented_type == Company::class) {
            $subject = "Новый отзыв про вашу компанию";
        }
// dd($subject);
        return (new MailMessage)
            ->subject(Lang::getFromJson($subject))
            // ->line(Lang::getFromJson('Пожалуйста, нажмите кнопку ниже, чтобы подтвердить свой адрес электронной почты.'))
            // ->action(Lang::getFromJson('Подтвердить регистрацию'), $verificationUrl)
            // ->line(Lang::getFromJson('Если вы не создали учетную запись, никаких дальнейших действий не требуется.'))
            ->view('notifications.comment.commentPublishedForEventOrCompanyOwnerMail', ['data' => ['comment' => $this->comment, 'user' => $notifiable]]);
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
