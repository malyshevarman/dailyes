<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\NewsletterNotificationsSenderJob;
use App\Newsletter;
use App\User;
use Log;

class NewsletterSender extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'run:newsletterSender {--newsletterId=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Newsletter Sender';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $id = $this->option('newsletterId');
        $newsletter = Newsletter::find($id)->where('is_active', true)->first();

        // foreach ($newsletters as $key => $newsletter) {
            if (!is_null($newsletter)) {
                $users = User::where('city', $newsletter->city['name'])->get();
                foreach ($users as $key => $user) {
                    dispatch(new NewsletterNotificationsSenderJob($user, $newsletter));
                }
                $newsletter->is_active = false;
                $newsletter->save();
                Log::channel('NotificationsLogFile')->info('Поставлено в очередь уведомлений по рассылке ' . $newsletter->subject . ' город ' . $newsletter->city['name'] . ' на ' . date('Y-m-d') . ': ' . $users->count() . "\r\n");
            } else {
                Log::channel('NotificationsLogFile')->info( "Рассылка id=" . $id . " не активна \r\n");
            }
        // }
    }
}
