<?php

Route::group([
    'namespace' => 'GalleryItem',
    'middleware' => ['role:admin|moderator']
], function () {
    /*
     * Additional
     */
    Route::group([
        'prefix' => 'gallery-item',
        'as' => 'gallery-item.',
    ], function () {
        Route::post('/store-multiple', 'GalleryItemController@storeMultiple')->name('store-multiple');
        Route::get('/remove-multiple/{galleryItem}', 'GalleryItemController@removeMultiple')->name('remove-multiple');
    });

    /*
     * Resource
     */
});
