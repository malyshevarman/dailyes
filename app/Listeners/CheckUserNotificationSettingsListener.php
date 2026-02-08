<?php

namespace App\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Events\NotificationSending;

class CheckUserNotificationSettingsListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \Illuminate\Notifications\Events\NotificationSending  $event
     * @return void
     */
    public function handle(NotificationSending $event)
    {
        // dd($event->notifiable->restricted_notifications->pluck('type')->toArray());
        if ($event->notifiable->restricted_notifications && $event->notifiable->restricted_notifications->count() > 0) {
            foreach ($event->notifiable->restricted_notifications->pluck('type')->toArray() as $key => $type) {
                if (strrpos(get_class($event->notification), $type) > -1) {
                    // dd(strrpos(get_class($event->notification), '\\' . $type . '\\'));
                    return false;
                }
            }
        }
        // dd(strrpos(get_class($event->notification), 'App\Notifications\Comment\\') > -1);
    }
}
