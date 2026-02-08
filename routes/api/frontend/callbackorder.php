<?php

Route::group([
    'namespace' => 'CallbackOrder',
], function () {
    /*
     * Additional
     */
    Route::group([
        'prefix' => 'callback',
        'as' => 'callback.',
    ], function () {
        Route::post('/callbackorder', 'CallbackOrderController@callback')->name('callback');
        Route::post('/contact-callbackorder', 'CallbackOrderController@contactPageCallback')->name('contactCallback');
        Route::post('/advertising-callbackorder', 'CallbackOrderController@advertisingPageCallback')->name('advertisingCallback');
    });

    /*
     * Resource
     */
});
