<?php

namespace App\Notifications\Event;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Event;
class EventWillEnd extends Notification
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
            ->subject('Период действия вашей акции скоро закончится')
            // ->greeting('Приветствуем!')
            // ->line('Ваша акция ' . $this->event->name . ' успешно проверена и опубликована на сайте!')
            // ->action('Карточка акции', route('frontend.event.show', $this->event))
            // ->line('Благодарим за использование нашего портала!')
            ->view('notifications.event.eventWillEndAfterThreeDaysMail', ['data' => ['event' => $this->event, 'user' => $notifiable]]);
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
