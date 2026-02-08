<?php

Route::group([
    'namespace' => 'Comment',
], function () {
    /*
     * Additional
     */
    Route::group([
        'prefix' => 'comment',
        'as' => 'comment.',
    ], function () {
    });

    /*
     * Resource
     */
    Route::resource('comment', 'CommentController')->only(['index', 'show']);
});
