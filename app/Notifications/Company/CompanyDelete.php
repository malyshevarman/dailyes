<?php

namespace App\Notifications\Company;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Lang;

class CompanyDelete extends Notification
{
    use Queueable;

    public $company;

    /**
     * Create a new notification instance.
     *
     * @param Company $company
     */
    public function __construct($company)
    {
        $this->company = $company;
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

         return (new MailMessage)
             ->subject('Компания успешно удалена')
             ->view('notifications.company.companyDeletedMail', ['data' => ['company' => $this->company, 'user' => $notifiable]]);
    }
}
