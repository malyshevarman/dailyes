<?php

Route::group([
    'namespace' => 'Rating',
], function () {
    /*
     * Additional
     */
    Route::group([
        'prefix' => 'rating',
        'as' => 'rating.',
    ], function () {
        require __DIR__ . '/rating/company.php';
        require __DIR__ . '/rating/event.php';
    });

    /*
     * Resource
     */
});
