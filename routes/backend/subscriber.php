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

    });

    /*
     * Resource
     */
    Route::resource('subscriber', 'SubscriberController')->only(['index', 'create', 'edit']);
});
