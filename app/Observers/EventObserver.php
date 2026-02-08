<?php

namespace App\Observers;

use App\Event;
use App\EventLabel;
use App\EventChangesLog;
use App\EventChangesFlags;
use App\Notifications\Event\EventPublished;
use App\Notifications\Event\EventRejected;
use App\Notifications\Event\EventRepublished;
use App\Notifications\Event\EventEdited;
use App\Notifications\Event\EventNewCreatedFromFavoriteCompany;
use App\Notifications\Event\EventCreated;

class EventObserver
{
    /**
     * Handle the event "created" event.
     *
     * @param  \App\Event $event
     * @return void
     */
    public function created(Event $event)
    {
        if (!empty($label = EventLabel::where('name', 'Новая акция')->first())) {
            $event->labels()->syncWithoutDetaching([$label->id => [
                'start' => $event->start,
                'end' => $event->start->addDays(3),
            ]]);
        }
        if (!empty($label = EventLabel::where('name', 'Успейте воспользоваться')->first())) {
            if ($event->end != NULL) {
                $event->labels()->syncWithoutDetaching([$label->id => [
                    'start' => $event->end->subDays(3),
                    'end' => $event->end,
                ]]);
            }
        }
        if (!$event->user->hasRole('admin')) {
        	$event->user->notify(new EventCreated($event));
        }
        $users = $event->company->users_who_have_added_to_favorites;

        if ($users !== null) {
            foreach ($users as $key => $value) {
            	if (!$value->hasRole('admin')) {
		        	$value->notify(new EventNewCreatedFromFavoriteCompany($event));
		        }
            }
        }
    }

    /**
     * Handle the event "updated" event.
     *
     * @param  \App\Event $event
     * @return void
     */
    public function updated(Event $event)
    {
        if (\Route::current()->getName() == 'api.backend.event.update') {
            if (isset($event->changes_flags)) {
                $flags = $event->changes_flags->toArray();
                foreach ($flags as $key => $value) {
                    if (is_bool($value)) {
                        $flags[$key] = false;
                    }
                }
                $event->changes_flags->fill($flags)->save();
            }

            if (!$event->user->hasRole('admin') && $event->user && $event->isDirty('published') && $event->published) {
                $event->user->notify(new EventPublished($event));
            }

            if (!$event->user->hasRole('admin') && $event->user && $event->isDirty('rejected') && $event->rejected) {
                $event->user->notify(new EventRejected($event));
            }

        } else {
            //больше 1 потому что updated_at всегда меняется
            if (count($event->getDirty()) > 1) {
                if (!isset($event->changes_flags)) {
                    $flags = new EventChangesFlags();
                    $flags->event_id = $event->id;
                } else {
                    $flags = $event->changes_flags;
                }
                foreach ($event->getDirty() as $key => $cf) {
                    if (isset($flags['is_changed_' . $key])) {
                        $flags['is_changed_' . $key] = true;
                    }
                }
                $flags->save();

                EventChangesLog::create([
                    'event_id' => $event->id,
                    'user_id' => Auth()->user() ? Auth()->user()->id : null,
                    'original_data' => $event->getOriginal(),
                    'changed_data' => $event->getDirty(),
                    'route' => \Route::current()->getName()
                ]);
            }

            if (!$event->user->hasRole('admin') && $event->published) {
                if ($event->isDirty(['end', 'start']) && $event->isClean(['name', 'slug', 'summary', 'about', 'image_download_id', 'background_download_id', 'star', 'rec', 'views', 'favorite'])) {
                    $event->user->notify(new EventRepublished($event));
                } else {
                    $event->user->notify(new EventEdited($event));
                }
            }

        }

        if ($event->isDirty('start') && !empty($label = EventLabel::where('name', 'Новая акция')->first())) {
            $event->labels()->syncWithoutDetaching([$label->id => [
                'start' => $event->start,
                'end' => $event->start->addDays(3),
            ]]);
        }
        if ($event->isDirty('end') && !empty($label = EventLabel::where('name', 'Успейте воспользоваться')->first())) {
            if ($event->end != NULL) {
                $event->labels()->syncWithoutDetaching([$label->id => [
                    'start' => $event->end->subDays(3),
                    'end' => $event->end,
                ]]);
            }
        }
    }

    /**
     * Handle the event "deleted" event.
     *
     * @param  \App\Event $event
     * @return void
     */
    public function deleted(Event $event)
    {
        //
    }

    /**
     * Handle the event "restored" event.
     *
     * @param  \App\Event $event
     * @return void
     */
    public function restored(Event $event)
    {
        //
    }

    /**
     * Handle the event "force deleted" event.
     *
     * @param  \App\Event $event
     * @return void
     */
    public function forceDeleted(Event $event)
    {
        //
    }
}
