<?php

Route::group([
    'namespace' => 'Download',
], function () {
    /*
     * Additional
     */
    Route::group([
        'prefix' => 'download',
        'as' => 'download.',
    ], function () {
        Route::group([
            'name' => 'download'
        ], function () {
            Route::post('/store-multiple', 'DownloadController@storeMultiple')->name('store-multiple');
        });
    });

    /*
     * Resource
     */
    Route::resource('download', 'DownloadController')->only(['store', 'show', 'destroy']);
});
