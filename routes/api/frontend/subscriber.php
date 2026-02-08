<?php

Route::group([
    'namespace' => 'Subscriber',
], function () {
    /*
     * Additional
     */
    Route::group([
        'prefix' => 'subscriber',
        'as' => 'subscriber.',
    ], function () {
        Route::post('/subscribe', 'SubscriberController@subscribe')->name('subscribe');
        Route::get('/unsubscribe/{id}', 'SubscriberController@unsubscribe')->name('unsubscribe');
    });

    /*
     * Resource
     */
});
