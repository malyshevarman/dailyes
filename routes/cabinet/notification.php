<?php

Route::group([
    'namespace' => 'Notification',
], function () {
    /*
     * Additional
     */
    Route::group([
        'prefix' => 'notification',
        'as' => 'notification.',
    ], function () {

    });

    /*
     * Resource
     */
    Route::resource('notification', 'NotificationController')->only(['index']);
});
