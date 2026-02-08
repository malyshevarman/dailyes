<?php

Route::group([
    'namespace' => 'Settings',
], function () {
    /*
     * Additional
     */
    Route::group([
        'as' => 'settings.',
    ], function () {
        Route::view('/settings', 'cabinet.settings.index')->name('index');
    });

    /*
     * Resource
     */
});
