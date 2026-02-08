<?php

Route::group([
    'namespace' => 'Category',
], function () {
    /*
     * Additional
     */
    Route::group([
        'prefix' => 'category',
        'as' => 'category.',
    ], function () {
        Route::get('all', 'CategoryController@all')->name('all');
    });

    /*
     * Resource
     */
});
