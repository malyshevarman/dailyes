<?php

namespace App\Notifications\Event;

use App\Event;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class EventRepublished extends Notification
{
    use Queueable;

    public $event;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($event)
    {
        $this->event = $event;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database', 'mail'];
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
            ->subject('Отлично, ваша акция снова опубликована')
            ->view('notifications.event.eventRepublishedMail', ['data' => ['event' => $this->event, 'user' => $notifiable]]);
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
            'text' => "Ваша акция <a href='" . route('frontend.event.show', $this->event) . "'>" . $this->event->name . "</a> опубликована повторно на сайте",
            'id' => $this->event->id,
            'type' => Event::class
        ];
    }
}
