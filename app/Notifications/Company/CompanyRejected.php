<?php

namespace App\Notifications\Company;

use App\Company;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CompanyRejected extends Notification
{
    use Queueable;

    public $company;

    /**
     * Create a new notification instance.
     *
     * @param Company $company
     */
    public function __construct(Company $company)
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
            'text' => "Ваша компания <a href='" . route('cabinet.company.edit', $this->company) . "'>" . $this->company->name . "</a> отклонена" . (empty($this->company->message) ? '' : ' (' . $this->company->message . ')'),
            'id' => $this->company->id,
            'type' => Company::class
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
            ->subject('К сожалению, ваша компания не прошла модерацию на dailyes.ru')
            ->view('notifications.company.companyRejectedMail', ['data' => ['company' => $this->company, 'user' => $notifiable]]);
    }
}
