<?php

namespace App\Notifications\Auth;

use Illuminate\Support\Facades\Lang;
use Illuminate\Notifications\Messages\MailMessage;

class ResetPassword extends \Illuminate\Auth\Notifications\ResetPassword
{
    /**
     * Build the mail representation of the notification.
     *
     * @param  mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        if (static::$toMailCallback) {
            return call_user_func(static::$toMailCallback, $notifiable, $this->token);
        }

        return (new MailMessage)
            ->subject(Lang::getFromJson('Сброс пароля'))
            ->line(Lang::getFromJson('Вы получили это письмо, потому что мы получили запрос на сброс пароля для вашей учетной записи.'))
            ->action(Lang::getFromJson('Сбросить пароль'), url(config('app.url') . route('password.reset', ['token' => $this->token, 'email' => $notifiable->getEmailForPasswordReset()], false)))
            ->line(Lang::getFromJson('Срок действия ссылки для сброса пароля истекает через :count минут.', ['count' => config('auth.passwords.users.expire')]))
            ->line(Lang::getFromJson('Если вы не запрашивали сброс пароля, никаких дальнейших действий не требуется.'));
    }
}
