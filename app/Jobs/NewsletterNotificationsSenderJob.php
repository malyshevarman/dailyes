<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Notifications\Newsletter\NewsletterNotification;
class NewsletterNotificationsSenderJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user;
    protected $newsletter;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($user, $newsletter)
    {
        $this->user = $user;

        $this->newsletter = $newsletter;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->user->notify(new NewsletterNotification($this->newsletter));
    }
}
