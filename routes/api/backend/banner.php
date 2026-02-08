<?php

Route::group([
    'namespace' => 'Banner',
    'middleware' => ['role:admin']
], function () {
    /*
     * Additional
     */
    Route::group([
        'prefix' => 'banner',
        'as' => 'banner.',
    ], function () {
        Route::post('filter', 'BannerController@filter')->name('filter');
        require __DIR__ . '/banner/place.php';
    });

    /*
     * Resource
     */
    Route::resource('banner', 'BannerController')->only(['store', 'show', 'update', 'destroy']);
});
