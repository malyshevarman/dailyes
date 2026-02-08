<?php

namespace App\Observers;

use App\Company;
use App\CompanyChangesLog;
use App\CompanyChangesFlags;
use App\Notifications\Company\CompanyPublished;
use App\Notifications\Company\CompanyRejected;
use App\Notifications\Company\CompanyCreated;

class CompanyObserver
{
    /**
     * Handle the company "created" event.
     *
     * @param  \App\Company $company
     * @return void
     */
    public function created(Company $company)
    {
        if (!$company->user->hasRole('admin')) {
            $company->user->notify(new CompanyCreated($company));
        }
    }

    /**
     * Handle the company "updated" event.
     *
     * @param  \App\Company $company
     * @return void
     */
    public function updated(Company $company)
    {
        // dd($company->getDirty());

            if (\Route::current()->getName() == 'api.backend.company.update') {
                if (isset($company->changes_flags)) {
                    $flags = $company->changes_flags->toArray();
                    foreach ($flags as $key => $value) {
                        if (is_bool($value)) {
                            $flags[$key] = false;
                        }
                    }
                    $company->changes_flags->fill($flags)->save();
                }

            } else {
                //больше 1 потому что updated_at всегда меняется
                if (count($company->getDirty()) > 1) {
                    if (!isset($company->changes_flags)) {
                        $flags = new CompanyChangesFlags();
                        $flags->company_id = $company->id;
                    } else {
                        $flags = $company->changes_flags;
                    }
                    foreach ($company->getDirty() as $key => $cf) {
                        if (isset($flags['is_changed_' . $key])) {
                            $flags['is_changed_' . $key] = true;
                        }
                    }
                    $flags->save();

                    CompanyChangesLog::create([
                        'company_id' => $company->id,
                        'user_id' => Auth()->user() ? Auth()->user()->id : null,
                        'original_data' => $company->getOriginal(),
                        'changed_data' => $company->getDirty(),
                        'route' => \Route::current()->getName()
                    ]);
                }

            }

        if (!$company->user->hasRole('admin') && $company->user && $company->isDirty('published') && $company->published) {
            $company->user->notify(new CompanyPublished($company));
        }

        if (!$company->user->hasRole('admin') && $company->user && $company->isDirty('rejected') && $company->rejected) {
            $company->user->notify(new CompanyRejected($company));
        }
    }

    /**
     * Handle the company "deleted" event.
     *
     * @param  \App\Company $company
     * @return void
     */
    public function deleted(Company $company)
    {
        //
    }

    /**
     * Handle the company "restored" event.
     *
     * @param  \App\Company $company
     * @return void
     */
    public function restored(Company $company)
    {
        //
    }

    /**
     * Handle the company "force deleted" event.
     *
     * @param  \App\Company $company
     * @return void
     */
    public function forceDeleted(Company $company)
    {
        //
    }
}
