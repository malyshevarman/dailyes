<?php

namespace App\Observers;

use App\ReportsAnswer;
use App\Notifications\Report\ReportAnswerCreated;

class ReportsAnswerObserver
{
    /**
     * Handle the reportAnswer "created" event.
     *
     * @param  \App\ReportsAnswer $reportAnswer
     * @return void
     */
    public function created(ReportsAnswer $reportAnswer)
    {
        if (!$reportAnswer->report->user->hasRole('admin')) {
            $reportAnswer->report->user->notify(new ReportAnswerCreated($reportAnswer));
        }
    }

    /**
     * Handle the reportAnswer "updated" event.
     *
     * @param  \App\ReportsAnswer $reportAnswer
     * @return void
     */
    public function updated(ReportsAnswer $reportAnswer)
    {
        //
    }

    /**
     * Handle the reportAnswer "deleted" event.
     *
     * @param  \App\ReportsAnswer $reportAnswer
     * @return void
     */
    public function deleted(ReportsAnswer $reportAnswer)
    {
        //
    }

    /**
     * Handle the reportAnswer "restored" event.
     *
     * @param  \App\ReportsAnswer $reportAnswer
     * @return void
     */
    public function restored(ReportsAnswer $reportAnswer)
    {
        //
    }

    /**
     * Handle the reportAnswer "force deleted" event.
     *
     * @param  \App\ReportsAnswer $reportAnswer
     * @return void
     */
    public function forceDeleted(ReportsAnswer $reportAnswer)
    {
        //
    }
}
