<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Event;

use Carbon\Carbon;
use App\Jobs\EventFavoriteWillEndNotificationsSenderJob;
use App\Jobs\EventFromFavoriteCompanyWillEndNotificationsSenderJob;
use App\Jobs\EventWillEndNotificationsSenderJob;
use App\Jobs\EventEndedNotificationsSenderJob;
use Log;

class EventWillEndOrEndedNotificationsSender extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'run:eventNotificationsSender';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'event Will End Or Ended Notifications Sender';

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
        // dd(Carbon::parse(date('Y-m-d'))->addDays(3)->toDateString());
        $eventsWillEnd = Event::where('end', Carbon::parse(date('Y-m-d'))->addDays(3)->toDateString())->get();

        foreach ($eventsWillEnd as $key => $value) {
            if (!$value->user->hasRole('admin')) {
                dispatch(new EventWillEndNotificationsSenderJob($value->user, $value));
            }
            $value->users_who_have_added_to_favorites->map(function ($user, $key) use ($value) {
                                                            if (!$user->hasRole('admin')) {
                                                                return dispatch(new EventFavoriteWillEndNotificationsSenderJob($user, $value));
                                                            }
                                                            
                                                        });
            $value->company->users_who_have_added_to_favorites->map(function ($user, $key) use ($value) {
                                                            if (!$user->hasRole('admin')) {
                                                                return dispatch(new EventFromFavoriteCompanyWillEndNotificationsSenderJob($user, $value));
                                                            }
                                                            
                                                        });
        }
        Log::channel('NotificationsLogFile')->info('Поставлено в очередь уведомлений по акциям, которые заканчиваются на ' . date('Y-m-d') . ': ' . $eventsWillEnd->count() . ' \r\n');


        $eventsEnded = Event::where('end', '<', date('Y-m-d'))->where('end', '<>', null)->where('active', true)->get();

        foreach ($eventsEnded as $key => $value) {
            if (!is_null($value->user)) {
                if (!$value->user->hasRole('admin')) {
                    dispatch(new EventEndedNotificationsSenderJob($value->user, $value));
                }
                
            }
            $value->active = false;
            $value->saveWithoutEvents();
        }

        Log::channel('NotificationsLogFile')->info('Поставлено в очередь уведомлений по акциям, которые закончились на ' . date('Y-m-d') . ': ' . $eventsEnded->count() . ' \r\n');
    }
}
