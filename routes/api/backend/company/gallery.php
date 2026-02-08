<?php

Route::group([
    'namespace' => 'GalleryItem',
], function () {
    /*
     * Additional
     */
    Route::group([
        'prefix' => 'gallery',
        'as' => 'gallery.',
    ], function () {
        Route::post('video', 'GalleryItemController@video')->name('video');
        Route::post('photo', 'GalleryItemController@photo')->name('photo');
    });

    /*
     * Resource
     */
});
