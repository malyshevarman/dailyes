<?php

namespace App\Notifications\Event;

use App\Event;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EventPublished extends Notification
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
        return ['database', 'mail'];
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
            'text' => "Ваша акция <a href='" . route('frontend.event.show', $this->event) . "'>" . $this->event->name . "</a> успешно проверена и опубликована на сайте",
            'id' => $this->event->id,
            'type' => Event::class
        ];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Поздравляем, ваша акция успешно опубликована на dailyes.ru')
            ->view('notifications.event.eventPublishedMail', ['data' => ['event' => $this->event, 'user' => $notifiable]]);
    }
}
