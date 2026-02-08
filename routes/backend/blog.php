<?php

Route::group([
    'namespace' => 'Blog',
    'middleware' => ['role:admin']
], function () {
    /*
     * Additional
     */
    Route::group([
        'prefix' => 'article',
        'as' => 'article.',
    ], function () {
    });

    /*
     * Resource
     */
    Route::resource('article', 'ArticleController')->only(['index', 'create', 'edit']);
});
