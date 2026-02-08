<?php

Route::group([
    'namespace' => 'Subscriber',
    'middleware' => ['role:admin']
], function () {
    /*
     * Additional
     */
    Route::group([
        'prefix' => 'subscriber',
        'as' => 'subscriber.',
    ], function () {
        Route::post('filter', 'SubscriberController@filter')->name('filter');
    });

    /*
     * Resource
     */
    Route::resource('subscriber', 'SubscriberController')->only(['store', 'show', 'update', 'destroy']);
});
