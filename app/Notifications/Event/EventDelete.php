<?php

namespace App\Notifications\Event;

use App\Event;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Lang;

class EventDelete extends Notification
{
    use Queueable;

    public $event;

    /**
     * Create a new notification instance.
     *
     * @param Event $event
     */
    public function __construct($event)
    {
        $this->event = $event;
    }

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
     * Get the array representation of the notification.
     *
     * @param  mixed $notifiable
     * @return array
     */


    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Акция успешно удалена')
            // ->line(Lang::getFromJson('АКЦИЯ УСПЕШНО УДАЛЕНА'))
            // ->line(Lang::getFromJson('Уважаемый(ая) ' . $this->data['user_name'] . '!'))
            // ->line(Lang::getFromJson('Созданная вами ранее акция ' . $this->data['event']->name . ' была успешно удалена.'))
            ->view('notifications.event.eventDeletedMail', ['data' => ['event' => $this->event, 'user' => $notifiable]]);
    }
}
