<?php

Route::group([
    'namespace' => 'Category',
    'middleware' => ['role:admin']
], function () {
    /*
     * Additional
     */
    Route::group([
        'prefix' => 'category',
        'as' => 'category.',
    ], function () {

    });

    /*
     * Resource
     */
    Route::resource('category', 'CategoryController')->only(['index', 'create', 'edit']);
});
