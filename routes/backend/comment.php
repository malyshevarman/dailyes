<?php

Route::group([
    'namespace' => 'Comment',
    'middleware' => ['role:admin']
], function () {
    /*
     * Additional
     */
    Route::group([
        'prefix' => 'comment',
        'as' => 'comment.',
    ], function () {
        require __DIR__ . '/comment/answer.php';
    });

    /*
     * Resource
     */
    Route::resource('comment', 'CommentController')->only(['index']);
});
