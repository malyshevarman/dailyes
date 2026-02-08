<?php

namespace App\Notifications\Subscriber;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class SubscriberSubscribe extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
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
     * @param  mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        // $data = [
        //     'name'   => $notifiable->name,
        //     'surname'=> $notifiable->last_name,
        //     'event_name' => $this->event->name,
        //     'event' => $this->event
        // ];

        return (new MailMessage)
            ->subject('Подписка на e-mail рассылку')
            // ->greeting('Приветствуем!')
            // ->line('Ваша акция ' . $this->event->name . ' успешно проверена и опубликована на сайте!')
            // ->action('Карточка акции', route('frontend.event.show', $this->event))
            // ->line('Благодарим за использование нашего портала!')
            ->view('notifications.subscriber.subscriberSubscribe', ['data' => ['user' => $notifiable]]);
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
