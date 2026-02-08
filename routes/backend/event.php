<?php

Route::group([
    'namespace' => 'Event',
], function () {
    /*
     * Additional
     */
    Route::group([
        'prefix' => 'event',
        'as' => 'event.',
        'middleware' => ['role:admin']
    ], function () {
        require __DIR__ . '/event/category.php';
        require __DIR__ . '/event/label.php';
    });

    /*
     * Resource
     */
    Route::resource('event', 'EventController')->only(['index', 'create', 'edit'])->middleware('role:admin|moderator');
});
