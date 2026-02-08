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
        require __DIR__ . '/banner/place.php';
    });

    /*
     * Resource
     */
    Route::resource('banner', 'BannerController')->only(['index', 'create', 'edit']);
});
