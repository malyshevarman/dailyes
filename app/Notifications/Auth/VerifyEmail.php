<?php

namespace App\Notifications\Auth;

use Illuminate\Support\Facades\Lang;
use Illuminate\Notifications\Messages\MailMessage;

class VerifyEmail extends \Illuminate\Auth\Notifications\VerifyEmail
{
    /**
     * Build the mail representation of the notification.
     *
     * @param  mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $verificationUrl = $this->verificationUrl($notifiable);

        if (static::$toMailCallback) {
            return call_user_func(static::$toMailCallback, $notifiable, $verificationUrl);
        }
        $data = [
            'name'   => $notifiable->name,
            'surname'=> $notifiable->last_name,
            'today_events' => \App\Event::whereDate('created_at', date('Y-m-d'))->limit(3)->get()
        ];
        return (new MailMessage)
            ->subject(Lang::getFromJson('Подтверждение регистрации на dailyes.ru'))
            // ->line(Lang::getFromJson('Пожалуйста, нажмите кнопку ниже, чтобы подтвердить свой адрес электронной почты.'))
            ->action(Lang::getFromJson('Подтвердить регистрацию'), $verificationUrl)
            // ->line(Lang::getFromJson('Если вы не создали учетную запись, никаких дальнейших действий не требуется.'))
            ->view('notifications.verificationMail', ['data' => $data]);
    }
}
