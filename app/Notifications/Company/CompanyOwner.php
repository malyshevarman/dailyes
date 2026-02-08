<?php

namespace App\Notifications\Company;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Lang;

class CompanyOwner extends Notification
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
        // $verificationUrl = route('api.cabinet.company.owner', ['company' => $this->data['company'], 'token' => $this->data['company']->verify_token, 'user_id' => $this->data['user_id']]);
        // return (new MailMessage)
        //     ->subject('Подтверждение прав на компанию')
        //     ->line(Lang::getFromJson('Пожалуйста, нажмите кнопку ниже, чтобы подтвердить права на компанию ' . $this->data['company']->name . '.'))
        //     ->action(Lang::getFromJson('Подтвердить регистрацию'), $verificationUrl)
        //     ->line(Lang::getFromJson('Если вы не понимаете в чем дело, никаких дальнейших действий не требуется.'));
        return (new MailMessage)
            ->subject('Подтверждение прав на компанию dailyes.ru')
            ->view('notifications.company.companyOwnerMail', ['data' => ['data' => $this->data, 'user' => $notifiable]]);
    }
}
