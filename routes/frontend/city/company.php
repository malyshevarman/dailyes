<?php

Route::group([
    'namespace' => 'Company',
], function () {
    /*
     * Additional
     */
    Route::group([
        'prefix' => 'company',
        'as' => 'company.',
    ], function () {
        require __DIR__ . '/company/category.php';
        require __DIR__ . '/company/tag.php';
    });

    /*
     * Resource
     */
});
