<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Console\Commands\NewsletterSender;
use App\Console\Commands\EventWillEndOrEndedNotificationsSender;
use App\Newsletter;
use Carbon\Carbon;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();
        $newsletters = Newsletter::all();

        foreach ($newsletters as $key => $newsletter) {
            // if (!is_null($newsletter->city['timezone'])) {
                // $currentCarbon = now()->format('h:i:s');
                // $cityCarbon = Carbon::parse()->setTimezone($newsletter->city['timezone'])->format('h:i:s');

                // $hourdiff = (strtotime($cityCarbon) - strtotime($currentCarbon))/3600;

                // dd(abs($hourdiff));
                // $time = Carbon::parse('11:00')->addHours(abs($hourdiff))->format('h:i');
                // dd($time);
                $schedule->command(NewsletterSender::class, ['--newsletterId=' . $newsletter->id])->weeklyOn(2, '12:00')->timezone(!is_null($newsletter->city['timezone']) ? $newsletter->city['timezone'] : config('app.timezone'));
            // } else {
            //     $schedule->command(NewsletterSender::class, ['--newsletterId=' . $newsletter->id])->weeklyOn(2, '11:00');
            // }
        }
        $schedule->command(EventWillEndOrEndedNotificationsSender::class)->dailyAt('00:00');
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
