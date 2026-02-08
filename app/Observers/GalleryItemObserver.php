<?php

namespace App\Observers;

use App\GalleryItem;
use App\CompanyChangesLog;
use App\CompanyChangesFlags;
use App\Event;
use App\Company;
use App\EventChangesLog;
use App\EventChangesFlags;
class GalleryItemObserver
{
    /**
     * Handle the gallery item "created" event.
     *
     * @param  \App\GalleryItem  $galleryItem
     * @return void
     */
    public function created(GalleryItem $galleryItem)
    {
        // dd($galleryItem->model);
    }

    /**
     * Handle the gallery item "updated" event.
     *
     * @param  \App\GalleryItem  $galleryItem
     * @return void
     */
    public function updated(GalleryItem $galleryItem)
    {
        $model = $galleryItem->model;

        if (\Route::current()->getName() == 'api.backend.company.update' || \Route::current()->getName() == 'api.backend.event.update') {
            if (isset($model->changes_flags)) {
                $model->changes_flags->is_changed_gallery_items = false;
                $model->changes_flags->save();
            }
        } else {

            if (isset($model->changes_flags)) {
                $model->changes_flags->is_changed_gallery_items = true;
                $model->changes_flags->save();
            } else {
                if (get_class($model) == 'App\Event') {
                    $model->changes_flags()->create([
                        'event_id' => $model->id,
                        'is_changed_gallery_items' => true
                    ]);
                } else {
                    $model->changes_flags()->create([
                        'company_id' => $model->id,
                        'is_changed_gallery_items' => true
                    ]);
                }
            }
            if (get_class($model) == 'App\Event') {
                EventChangesLog::create([
                    'event_id' => $model->id,
                    'user_id' => Auth()->user() ? Auth()->user()->id : null,
                    'original_data' => array('gallery_items' => $model->gallery_items->pluck('id')),
                    'changed_data' => array('gallery_items' => array($galleryItem->id)),
                    'route' => \Route::current()->getName()
                ]);
            } else {
                CompanyChangesLog::create([
                    'company_id' => $model->id,
                    'user_id' => Auth()->user() ? Auth()->user()->id : null,
                    'original_data' => array('gallery_items' => $model->gallery_items->pluck('id')),
                    'changed_data' => array('gallery_items' => array($galleryItem->id)),
                    'route' => \Route::current()->getName()
                ]);
            }
        }
    }

    /**
     * Handle the gallery item "deleted" event.
     *
     * @param  \App\GalleryItem  $galleryItem
     * @return void
     */
    public function deleted(GalleryItem $galleryItem)
    {
        //
    }

    /**
     * Handle the gallery item "restored" event.
     *
     * @param  \App\GalleryItem  $galleryItem
     * @return void
     */
    public function restored(GalleryItem $galleryItem)
    {
        //
    }

    /**
     * Handle the gallery item "force deleted" event.
     *
     * @param  \App\GalleryItem  $galleryItem
     * @return void
     */
    public function forceDeleted(GalleryItem $galleryItem)
    {
        //
    }
}
