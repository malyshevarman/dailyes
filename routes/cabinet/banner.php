<?php

Route::group([
    'namespace' => 'Banner',
], function () {
    /*
     * Additional
     */
    Route::group([
        'prefix' => 'banner',
        'as' => 'banner.',
    ], function () {

    });

    /*
     * Resource
     */
    Route::resource('banner', 'BannerController')->only(['index']);
});
