<?php

Route::group([
    'namespace' => 'Event',
], function () {
    /*
     * Additional
     */
    Route::group([
        'prefix' => 'stocks',
        'as' => 'event.',
    ], function () {
        require __DIR__ . '/event/category.php';
        require __DIR__ . '/event/tag.php';
    });

    /*
     * Resource
     */
});
