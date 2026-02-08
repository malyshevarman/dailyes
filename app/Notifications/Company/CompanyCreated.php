<?php

namespace App\Notifications\Company;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class CompanyCreated extends Notification
{
    use Queueable;

    public $company;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($company)
    {
        $this->company = $company;
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
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Модерация бизнес-аккаунта на dailyes.ru')
            ->view('notifications.company.companyCreatedMail', ['data' => ['company' => $this->company, 'user' => $notifiable]]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'text' => "Ваша компания <b>" . $this->company->name . "</b> успешно создана и отправлена на модерацию",
            'id' => $this->company->id,
            'type' => Company::class
        ];
    }
}
