<?php

Route::group([
    'namespace' => 'Video',
    'middleware' => ['role:admin']
], function () {
    /*
     * Additional
     */
    Route::group([
        'prefix' => 'video',
        'as' => 'video.',
    ], function () {
        Route::group([
            'name' => 'video'
        ], function () {
            Route::post('/store-multiple', 'VideoController@storeMultiple')->name('store-multiple');
        });
    });

    /*
     * Resource
     */
});
