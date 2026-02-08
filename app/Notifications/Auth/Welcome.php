<?php

namespace App\Notifications\Auth;

use Illuminate\Support\Facades\Lang;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
class Welcome extends Notification
{
    use Queueable;


    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Build the mail representation of the notification.
     *
     * @param  mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        // $verificationUrl = $this->verificationUrl($notifiable);

        // if (static::$toMailCallback) {
        //     return call_user_func(static::$toMailCallback, $notifiable, $verificationUrl);
        // }
        // $data = [
        //     'name'   => $notifiable->name,
        //     'surname'=> $notifiable->last_name,
        //     'today_events' => \App\Event::whereDate('created_at', date('Y-m-d'))->limit(3)->get()
        // ];
        return (new MailMessage)
            ->subject(Lang::getFromJson('Добро пожаловать на dailyes.ru'))
            // ->line(Lang::getFromJson('Пожалуйста, нажмите кнопку ниже, чтобы подтвердить свой адрес электронной почты.'))
            // ->action(Lang::getFromJson('Подтвердить регистрацию'), $verificationUrl)
            // ->line(Lang::getFromJson('Если вы не создали учетную запись, никаких дальнейших действий не требуется.'))
            ->view('notifications.welcome', ['data' => ['user' => $notifiable]]);
    }
}
