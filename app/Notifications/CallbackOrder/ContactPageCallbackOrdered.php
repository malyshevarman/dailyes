<?php

namespace App\Notifications\CallbackOrder;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ContactPageCallbackOrdered extends Notification
{
    use Queueable;

    // public $company;

    /**
     * Create a new notification instance.
     *
     * @param Company $company
     */
    public function __construct($validData)
    {
        $this->data = $validData;
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

    // /**
    //  * Get the array representation of the notification.
    //  *
    //  * @param  mixed $notifiable
    //  * @return array
    //  */
    // public function toArray($notifiable)
    // {
    //     return [
    //         'text' => "Ваша компания <a href='" . route('frontend.company.show', $this->company) . "'>" . $this->company->name . "</a> успешно проверена и опубликована на сайте",
    //         'id' => $this->company->id,
    //         'type' => Company::class
    //     ];
    // }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        // return (new MailMessage)
        //     ->subject($this->data['subject'])
        //     ->line('Имя: ' . $this->data['name'])
        //     ->line('Телефон: ' . $this->data['phone'])
        //     ->line('Город: ' . $this->data['city'])
        //     ->line('E-mail: ' . $this->data['mail'])
        //     ->line('Причина обращения: ' . $this->data['subject'])
        //     ->line('Описание: ' . $this->data['description'])
        //     ->action('Файл', "https://dailyes.ru/storage/" . (isset($this->data['attachment']) ? $this->data['attachment'] : ''));
        return (new MailMessage)
            ->subject($this->data['subject'])
            // ->greeting('Приветствуем!')
            // ->line('Ваша акция ' . $this->event->name . ' успешно проверена и опубликована на сайте!')
            // ->action('Карточка акции', route('frontend.event.show', $this->event))
            // ->line('Благодарим за использование нашего портала!')
            ->view('notifications.contactPageCallbackOrderedMail', ['data' => ['user' => $notifiable, 'data' => $this->data]]);
    }
}
