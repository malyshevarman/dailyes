<?php

namespace App\Notifications\Test;

use App\Event;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Lang;
use Illuminate\Notifications\Messages\MailMessage;

class TestEmail extends Notification
{
    /**
     * Build the mail representation of the notification.
     *
     * @param  mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function __construct($data)
    {
        $this->data = $data;
    }
    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $data = [
            'name'   =>'Arman',
            'surname'=> 'Malyshev',
            'today_events' => null
        ];
        return (new MailMessage)
            ->subject('Подтвердите регистрацию')
            ->line('Пожалуйста, нажмите кнопку ниже, чтобы подтвердить свой адрес электронной почты.')
            ->action('Подтвердить регистрацию', '/')
            ->line('Если вы не создали учетную запись, никаких дальнейших действий не требуется.')
            ->view('notifications.welcome',['data' => $data,'actionUrl'=>""]);
    }
}
