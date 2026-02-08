<?php

namespace App\Notifications\Report;

// use App\Report;
use App\ReportsAnswer;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ReportAnswerCreated extends Notification
{
    use Queueable;

    public $reportsAnswer;

    /**
     * Create a new notification instance.
     *
     * @param Company $company
     */
    public function __construct(ReportsAnswer $reportsAnswer)
    {
        $this->reportsAnswer = $reportsAnswer;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [
            'database', 
            // 'mail'
        ];
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
            'text' => "Ответ на жалобу на " . 
                    ($this->reportsAnswer->report->reportable_type == 'App\Company' ? 'компанию ' : 'акцию ') . 
                    " <a href='" . route(($this->reportsAnswer->report->reportable_type == 'App\Company' ? 'frontend.company.show' : 'frontend.event.show'), $this->reportsAnswer->report->reportable) . "'>" . $this->reportsAnswer->report->reportable->name . "</a> " . 
                    '(' . $this->reportsAnswer->text . ')',
            'id' => $this->reportsAnswer->id,
            'type' => ReportsAnswer::class,
            'reportable_type' => $this->reportsAnswer->report->reportable_type
        ];
    }

    // /**
    //  * Get the mail representation of the notification.
    //  *
    //  * @param  mixed $notifiable
    //  * @return \Illuminate\Notifications\Messages\MailMessage
    //  */
    // public function toMail($notifiable)
    // {
    //     $data = [
    //         'name'   => $notifiable->name,
    //         'surname'=> $notifiable->last_name,
    //         'company_name' => $this->company->name,
    //         'company' => $this->company
    //     ];
    //     return (new MailMessage)
    //         ->subject('Ваша компания ' . $this->company->name . ' опубликована')
    //         ->greeting('Приветствуем!')
    //         ->line('Ваша компания ' . $this->company->name . ' успешно проверена и опубликована на сайте!')
    //         ->action('Карточка компании', route('frontend.company.show', $this->company))
    //         ->line('Благодарим за использование нашего портала!')
    //         ->view('notifications.company.companyPublishedMail', ['data' => $data]);
    // }
}
