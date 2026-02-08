<?php

Route::group([
    'namespace' => 'Article',
    'middleware' => ['role:admin']
], function () {
    /*
     * Additional
     */
    Route::group([
        'prefix' => 'article',
        'as' => 'article.',
    ], function () {
        Route::post('filter', 'ArticleController@filter')->name('filter');
        Route::group([
            'prefix' => '{article}',
        ], function () {
            Route::post('toggle', 'ArticleController@toggle')->name('toggle');
        });
    });

    /*
     * Resource
     */
    Route::resource('article', 'ArticleController')->only(['store', 'show', 'update', 'destroy']);
});
